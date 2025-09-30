<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('organizer')->where('status', 'dipublikasikan')->get();
        return ActivityResource::collection($activities);
    }

    public function store(StoreActivityRequest $request)
    {
        $data = array_merge($request->validated(), ['status' => 'menunggu verifikasi admin']);
        $activity = Activity::create($data);
        return new ActivityResource($activity->load('organizer'));
    }

    public function show(Activity $activity)
    {
        return new ActivityResource($activity->load('organizer'));
    }

   public function mine(Request $request)
    {
        // 1. Validasi dulu bahwa organizer_id ada di request dan valid
        $validated = $request->validate([
            'organizer_id' => 'required|integer|exists:organizers,organizer_id'
        ]);

        // 2. Ambil organizer_id dari hasil validasi
        $organizerId = $validated['organizer_id'];
        
        // 3. Eager load relasi 'organizer' untuk mengambil namanya nanti
        $activities = Activity::with('organizer')
            ->where('organizer_id', $organizerId)
            ->get();

        // 4. Kembalikan hasilnya menggunakan resource
        return ActivityResource::collection($activities);
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());
        return new ActivityResource($activity->load('organizer'));
    }

    public function schedule(Request $request, Activity $activity)
    {
        if ($activity->status !== 'dipublikasikan') {
            return response()->json(['message' => 'Hanya jadwal kegiatan yang sudah dipublikasikan yang dapat diubah.'], 403);
        }
        $validated = $request->validate([
            'activity_start_date' => 'required|date',
            'activity_end_date' => 'required|date|after_or_equal:activity_start_date',
        ]);
        $activity->update($validated);
        return new ActivityResource($activity->load('organizer'));
    }

    public function destroy(Activity $activity)
    {
        if ($activity->status !== 'menunggu verifikasi admin') {
            return response()->json(['message' => 'Hanya kegiatan yang belum diverifikasi yang dapat dihapus.'], 403);
        }
        $activity->delete();
        return response()->json(['message' => 'Kegiatan berhasil dihapus.'], 200);
    }

    public function approve(Activity $activity)
    {
        $activity->update(['status' => 'dipublikasikan']);
        return new ActivityResource($activity->load('organizer'));
    }

    public function reject(Request $request, Activity $activity)
    {
        $validated = $request->validate(['rejection_reason' => 'required|string|min:10']);
        $activity->update([
            'status' => 'ditolak',
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        return new ActivityResource($activity->load('organizer'));
    }
}