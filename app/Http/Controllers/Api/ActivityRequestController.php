<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityRequest;
use Illuminate\Http\Request;

class ActivityRequestController extends Controller
{
    // POST /api/activity_request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'organizer_id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'proposed_start_date' => 'required|date',
            'proposed_end_date' => 'required|date|after:proposed_start_date',
            'location' => 'nullable|string|max:255',
        ]);

        $activityRequest = ActivityRequest::create($validated);
        return response()->json(['message' => 'Request created', 'data' => $activityRequest], 201);
    }

    // GET /api/activity_request (semua request)
    public function index()
    {
        return response()->json(ActivityRequest::all(), 200);
    }

    // GET /api/activity_request/mine (dummy: anggap organizer_id = 1)
    public function mine()
    {
        $mine = ActivityRequest::where('organizer_id', 1)->get();
        return response()->json($mine, 200);
    }

    // GET /api/activity_request/{id}
    public function show($id)
    {
        $activityRequest = ActivityRequest::find($id);
        if (! $activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($activityRequest, 200);
    }

    // PUT /api/activity_request/{id}
    public function update(Request $request, $id)
    {
        $activityRequest = ActivityRequest::find($id);
        if (! $activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'proposed_start_date' => 'sometimes|required|date',
            'proposed_end_date' => 'sometimes|required|date|after:proposed_start_date',
            'location' => 'nullable|string|max:255',
        ]);

        $activityRequest->update($validated);
        return response()->json(['message' => 'Request updated', 'data' => $activityRequest], 200);
    }

    // DELETE /api/activity_request/{id}
    public function destroy($id)
    {
        $activityRequest = ActivityRequest::find($id);
        if (! $activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $activityRequest->delete();
        return response()->json(['message' => 'Request deleted'], 200);
    }

    // PATCH /api/activity_request/{id}/approve
    public function approve($id)
    {
        $activityRequest = ActivityRequest::find($id);
        if (! $activityRequest) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $activityRequest->update(['status' => 'approved', 'rejection_note' => null]);
        return response()->json(['message' => 'Request approved', 'data' => $activityRequest], 200);
    }

    // PATCH /api/activity_request/{id}/reject
    public function reject(Request $request, $id)
    {
        $activityRequest = ActivityRequest::find($id);
        if (! $activityRequest) {
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
