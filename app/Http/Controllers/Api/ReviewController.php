<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Volunteer;
use App\Models\Organizer;
use App\Models\Activity;
use App\Models\Admin;

class ReviewController extends Controller
{
    // List review
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user instanceof Admin) {
            return response()->json(
                Review::with(['volunteer', 'organizer', 'activity'])->latest()->get()
            );
        } elseif ($user instanceof Organizer) {
            return response()->json(
                Review::with(['volunteer', 'organizer', 'activity'])
                    ->where('organizer_id', $user->organizer_id)
                    ->latest()->get()
            );
        } elseif ($user instanceof Volunteer) {
            return response()->json(
                Review::with(['volunteer', 'organizer', 'activity'])
                    ->where('volunteer_id', $user->volunteer_id)
                    ->latest()->get()
            );
        }

        return response()->json([], 403);
    }

    // Simpan review (hanya volunteer)
    public function store(Request $request)
    {
        $user = auth('volunteer')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!($user instanceof Volunteer)) {
            return response()->json(['message' => 'Only volunteers can create reviews'], 403);
        }

        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,activity_id',
            'rating'      => 'required|integer|min:1|max:5',
            'comment'     => 'nullable|string',
        ]);

        $review = Review::create([
            'volunteer_id' => $user->volunteer_id,
            'activity_id'  => $validated['activity_id'],
            'rating'       => $validated['rating'],
            'comment'      => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'Review berhasil dibuat!',
            'review'  => $review
        ], 201);
    }

    // Tampil review by ID
    public function filterOne($id)
    {
        return Review::with(['volunteer', 'organizer', 'activity'])->findOrFail($id);
    }

    // Hapus review
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $review = Review::findOrFail($id);

        if (
            $user instanceof Admin ||
            ($user instanceof Volunteer && $review->volunteer_id === $user->volunteer_id)
        ) {
            $review->delete();
            return response()->json(['message' => 'Review deleted']);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }

    // Update review (safe version)
    public function update(Request $request, $id)
    {
        $user = auth('volunteer')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        if ($review->volunteer_id !== $user->volunteer_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|nullable',
        ]);

        $review->update($validated);

        return response()->json([
            'message' => 'Review updated successfully!',
            'review'  => $review,
        ]);
    }

    // Filter review by activity
    public function filterActivity($activity_id)
    {
        return Review::with(['volunteer', 'organizer', 'activity'])
            ->where('activity_id', $activity_id)
            ->latest()
            ->get();
    }
}
