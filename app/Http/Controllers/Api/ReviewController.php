<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Volunteer;
use App\Models\Organizer;
use App\Models\Activity;

class ReviewController extends Controller
{
    /**
     * list review 
     */
    public function index(Request $request)
    {
        
        $user = $request->user();

        if ($user instanceof \App\Models\Admin) {
            // Admin melihat semua review
            return response()->json(
                Review::with(['volunteer', 'organizer', 'activity'])->latest()->get()
            );
        } elseif ($user instanceof \App\Models\Organizer) {
            // Organizer lihat review aktivitas
            return response()->json(
                Review::with(['volunteer', 'organizer', 'activity'])
                    ->where('organizer_id', $user->organizer_id)
                    ->latest()->get()
            );
        } elseif ($user instanceof \App\Models\Volunteer) {
            // Volunteer can see their own reviews
            return response()->json(
                Review::with(['volunteer', 'organizer', 'activity'])
                    ->where('volunteer_id', $user->volunteer_id)
                    ->latest()->get()
            );
        }

        return response()->json([], 403);
    }

    /**
     * Simpan review (volunteer saja)
     */
    public function store(Request $request)
    {
        $user = auth('volunteer')->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
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
//tampil review by review_id
    public function filterOne($id)
{
    return Review::with(['volunteer', 'organizer', 'activity'])->findOrFail($id);
}

    /**
     *hapus review
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $review = Review::findOrFail($id);

        if (
            $user instanceof \App\Models\Admin ||
            ($user instanceof \App\Models\Volunteer && $review->volunteer_id === $user->volunteer_id)
        ) {
            $review->delete();
            return response()->json(['message' => 'Review deleted']);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }

    //update review
    public function update(Request $request, $id)
{
    $review = Review::findOrFail($id);
    $user = $request->user();

    if (!($user instanceof \App\Models\Volunteer) || $review->volunteer_id !== $user->volunteer_id) {
        return response()->json(['message' => 'Forbidden'], 403);
    }

    $validated = $request->validate([
        'rating'  => 'integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $review->update($validated);

    return response()->json(['message' => 'Review updated', 'review' => $review]);
}

public function filterActivity($activity_id)
{
    return Review::with(['volunteer', 'organizer', 'activity'])
        ->where('activity_id', $activity_id)
        ->latest()
        ->get();
}


}
