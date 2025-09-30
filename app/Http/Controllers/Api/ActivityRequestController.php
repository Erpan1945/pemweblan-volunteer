<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityRequest;
use App\Models\Admin;
use App\Models\Organizer;
use Illuminate\Http\Request;

class ActivityRequestController extends Controller
{
    // POST /api/activity_request
    public function store(Request $request)
    {
        // Dapatkan user organizer yang sedang login
        $organizer = auth('organizer')->user();

        // Cek apakah user adalah instance dari model Organizer
        if (!$organizer instanceof \App\Models\Organizer) {
            return response()->json(['message' => 'Hanya organizer yang dapat membuat request'], 403);
        }

        $validated = $request->validate([
            // Hapus organizer_id dari validasi, akan diisi otomatis
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after:registration_start_date',
            'activity_start_date' => 'required|date|after:registration_end_date',
            'activity_end_date' => 'required|date|after:activity_start_date',
        ]);

        // Tambahkan ID organizer yang login secara otomatis
        $validated['organizer_id'] = $organizer->organizer_id;

        $activityRequest = ActivityRequest::create($validated);
        return response()->json(['message' => 'Request created', 'data' => $activityRequest], 201);
    }

    // GET /api/activity_request (semua request)
    public function index()
    {
        // Hanya Admin yang boleh melihat semua request
        if (!auth('admin')->check()) {
            return response()->json(['message' => 'Akses ditolak. Hanya untuk Admin.'], 403);
        }
        return response()->json(ActivityRequest::all(), 200);
    }

    // GET /api/activity_request/mine
    public function mine()
    {
        // Dapatkan organizer yang sedang login
        $organizer = auth('organizer')->user();
        if (!$organizer instanceof \App\Models\Organizer) {
            return response()->json(['message' => 'Endpoint ini hanya untuk organizer'], 403);
        }

        // Ambil request yang dimiliki oleh organizer tersebut
        $mine = ActivityRequest::where('organizer_id', $organizer->organizer_id)->get();
        return response()->json($mine, 200);
    }

    // GET /api/activity_request/{id}
    public function show($id)
    {
        // Siapapun yang login (volunteer, organizer, admin) boleh melihat detail
        if (!auth('volunteer')->check() && !auth('organizer')->check() && !auth('admin')->check()) {
            return response()->json(['message' => 'Anda harus login untuk melihat detail'], 401);
        }

        $activityRequest = ActivityRequest::find($id);
        if (!$activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($activityRequest, 200);
    }

    // PUT /api/activity_request/{id}
    public function update(Request $request, $id)
    {
        $organizer = auth('organizer')->user();
        if (!$organizer instanceof \App\Models\Organizer) {
            return response()->json(['message' => 'Hanya organizer yang dapat mengubah request'], 403);
        }

        $activityRequest = ActivityRequest::find($id);
        if (!$activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // Tambahan: Cek kepemilikan request
        if ($activityRequest->organizer_id !== $organizer->organizer_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengubah request ini'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            // ... (validasi lainnya sesuaikan)
        ]);

        $activityRequest->update($validated);
        return response()->json(['message' => 'Request updated', 'data' => $activityRequest], 200);
    }

    // DELETE /api/activity_request/{id}
    public function destroy($id)
    {
        $organizer = auth('organizer')->user();
        if (!$organizer instanceof \App\Models\Organizer) {
            return response()->json(['message' => 'Hanya organizer yang dapat menghapus request'], 403);
        }

        $activityRequest = ActivityRequest::find($id);
        if (!$activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        // Tambahan: Cek kepemilikan request
        if ($activityRequest->organizer_id !== $organizer->organizer_id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk menghapus request ini'], 403);
        }

        $activityRequest->delete();
        return response()->json(['message' => 'Request deleted'], 200);
    }

    // PATCH /api/activity_request/{id}/approve
    public function approve($id)
    {
        // Hanya Admin yang bisa approve
        if (!auth('admin')->check()) {
            return response()->json(['message' => 'Akses ditolak. Hanya untuk Admin.'], 403);
        }

        $activityRequest = ActivityRequest::find($id);
        if (!$activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $activityRequest->update(['status' => 'approved', 'rejection_note' => null]);
        return response()->json(['message' => 'Request approved', 'data' => $activityRequest], 200);
    }

    // PATCH /api/activity_request/{id}/reject
    public function reject(Request $request, $id)
    {
        // Hanya Admin yang bisa reject
        if (!auth('admin')->check()) {
            return response()->json(['message' => 'Akses ditolak. Hanya untuk Admin.'], 403);
        }
        
        $activityRequest = ActivityRequest::find($id);
        if (!$activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'rejection_note' => 'required|string|max:500',
        ]);

        $activityRequest->update([
            'status' => 'rejected',
            'rejection_note' => $validated['rejection_note'],
        ]);

        return response()->json(['message' => 'Request rejected', 'data' => $activityRequest], 200);
    }
}