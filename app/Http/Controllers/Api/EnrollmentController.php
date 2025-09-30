<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Activity;
use App\Models\Volunteer;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    /**
     * GET /api/enrollments
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user instanceof \App\Models\Admin) {
            $enrollments = Enrollment::with(['activity', 'volunteer'])->get();
            return response()->json(['message' => 'Daftar semua pendaftaran', 'data' => $enrollments], 200);
        }

        if ($user instanceof Organizer) {
            $activitiesIds = Activity::where('organizer_id', $user->organizer_id)->pluck('id')->toArray();
            $enrollments = Enrollment::with(['activity', 'volunteer'])
                ->whereIn('activity_id', $activitiesIds)
                ->get();
            return response()->json(['message' => 'Daftar pendaftar untuk kegiatan Anda', 'data' => $enrollments], 200);
        }

        if ($user instanceof Volunteer) {
            $enrollments = Enrollment::with('activity')
                ->where('volunteer_id', $user->volunteer_id)
                ->get();
            return response()->json(['message' => 'Daftar pendaftaran Anda', 'data' => $enrollments], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * GET /api/enrollments/{enrollment}
     */
    public function show(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user instanceof \App\Models\Admin) {
            // allowed
        } elseif ($user instanceof Organizer) {
            if ($enrollment->activity->organizer_id !== $user->organizer_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif ($user instanceof Volunteer) {
            if ($enrollment->volunteer_id !== $user->volunteer_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'Detail pendaftaran',
            'data' => $enrollment->load(['activity', 'volunteer'])
        ], 200);
    }

    /**
     * POST /api/enrollments
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (! ($user instanceof Volunteer)) {
            return response()->json(['message' => 'Only volunteers can enroll'], 403);
        }

        $validator = Validator::make($request->all(), [
            'activity_id' => 'required|integer|exists:activities,id',
            'notes' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $activity = Activity::findOrFail($request->activity_id);

        if (isset($activity->registration_start_date) && isset($activity->registration_end_date)) {
            $now = now();
            if ($now->lt($activity->registration_start_date) || $now->gt($activity->registration_end_date)) {
                return response()->json(['message' => 'Pendaftaran untuk kegiatan ini tidak dibuka saat ini'], 422);
            }
        }

        $exists = Enrollment::where('activity_id', $activity->id)
            ->where('volunteer_id', $user->volunteer_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Anda sudah mendaftar untuk kegiatan ini'], 409);
        }

        if (isset($activity->capacity) && $activity->capacity !== null) {
            $acceptedCount = Enrollment::where('activity_id', $activity->id)
                ->where('status', 'approved')
                ->count();
            if ($acceptedCount >= $activity->capacity) {
                return response()->json(['message' => 'Kapasitas kegiatan sudah penuh'], 422);
            }
        }

        $enrollment = Enrollment::create([
            'activity_id' => $activity->id,
            'volunteer_id' => $user->volunteer_id,
            'status' => 'pending',
            'notes' => $request->notes ?? null,
        ]);

        return response()->json(['message' => 'Pendaftaran berhasil', 'data' => $enrollment], 201);
    }

    /**
     * PUT/PATCH /api/enrollments/{enrollment}
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user instanceof Volunteer) {
            if ($enrollment->volunteer_id !== $user->volunteer_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif (! ($user instanceof \App\Models\Admin)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $enrollment->update($request->only(['notes']));

        return response()->json(['message' => 'Enrollment updated', 'data' => $enrollment], 200);
    }

    /**
     * PATCH /api/enrollments/{enrollment}/status
     */
    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();

        if ($user instanceof Organizer) {
            if ($enrollment->activity->organizer_id !== $user->organizer_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif (! ($user instanceof \App\Models\Admin)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($request->status === 'approved' && isset($enrollment->activity->capacity)) {
            $acceptedCount = Enrollment::where('activity_id', $enrollment->activity->id)
                ->where('status', 'approved')
                ->count();
            if ($acceptedCount >= $enrollment->activity->capacity) {
                return response()->json(['message' => 'Kapasitas kegiatan sudah penuh'], 422);
            }
        }

        $enrollment->status = $request->status;
        $enrollment->save();

        return response()->json(['message' => 'Status pendaftaran diperbarui', 'data' => $enrollment], 200);
    }

    /**
     * DELETE /api/enrollments/{enrollment}
     */
    public function destroy(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user instanceof Volunteer) {
            if ($enrollment->volunteer_id !== $user->volunteer_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif (! ($user instanceof \App\Models\Admin)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $enrollment->delete();

        return response()->json(['message' => 'Pendaftaran dibatalkan / dihapus'], 200);
    }

    /**
     * GET /api/user/{volunteer}/enrollments
     */
    public function getByUser(Volunteer $volunteer)
    {
        $enrollments = Enrollment::with('activity')
            ->where('volunteer_id', $volunteer->volunteer_id)
            ->get();

        return response()->json(['message' => 'Daftar pendaftaran user', 'data' => $enrollments], 200);
    }

    /**
     * GET /api/activity/{activity}/enrollments
     */
    public function getByActivity(Request $request, Activity $activity)
    {
        $user = $request->user();

        if ($user instanceof Organizer) {
            if ($activity->organizer_id !== $user->organizer_id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } elseif (! ($user instanceof \App\Models\Admin)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $enrollments = Enrollment::with('volunteer')
            ->where('activity_id', $activity->id)
            ->get();

        return response()->json(['message' => 'Daftar pendaftar kegiatan', 'data' => $enrollments], 200);
    }
}