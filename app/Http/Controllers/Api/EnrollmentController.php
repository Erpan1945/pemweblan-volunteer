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
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

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

    public function show(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $enrollment->load(['activity', 'volunteer']);
        if ($user instanceof Organizer && (!$enrollment->activity || $enrollment->activity->organizer_id !== $user->organizer_id)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($user instanceof Volunteer && $enrollment->volunteer_id !== $user->volunteer_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'message' => 'Detail pendaftaran',
            'data' => $enrollment
        ], 200);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (!($user instanceof Volunteer)) {
            return response()->json(['message' => 'Only volunteers can enroll'], 403);
        }

        $validator = Validator::make($request->all(), [
            'activity_id' => 'required|integer|exists:activities,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $activity = Activity::find($request->activity_id);

        if (!$activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $now = now();
        if (isset($activity->registration_start_date) && $now->lt($activity->registration_start_date) ||
            isset($activity->registration_end_date) && $now->gt($activity->registration_end_date)) {
            return response()->json(['message' => 'Pendaftaran untuk kegiatan ini tidak dibuka saat ini'], 422);
        }

        $exists = Enrollment::where('activity_id', $activity->id)
            ->where('volunteer_id', $user->volunteer_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Anda sudah mendaftar untuk kegiatan ini'], 409);
        }

        if (isset($activity->capacity)) {
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
        ]);

        return response()->json(['message' => 'Pendaftaran berhasil', 'data' => $enrollment], 201);
    }

    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,approve,reject',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $enrollment->load('activity');

        if ($user instanceof Organizer && (!$enrollment->activity || $enrollment->activity->organizer_id !== $user->organizer_id)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if (!($user instanceof \App\Models\Admin)) {
            if (!($user instanceof Organizer)) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
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

    public function destroy(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($user instanceof \App\Models\Admin) {
            $enrollment->delete();
            return response()->json(['message' => 'Pendaftaran dibatalkan / dihapus'], 200);
        }
        if ($user instanceof Volunteer && $enrollment->volunteer_id === $user->volunteer_id) {
            $enrollment->delete();
            return response()->json(['message' => 'Pendaftaran dibatalkan / dihapus'], 200);
        }
        return response()->json(['message' => 'Forbidden'], 403);
    }
}