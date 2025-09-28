<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return response()->json($activities);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'organizer_id' => 'required|integer|exists:organizers,organizer_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'required|date',
            'activity_end_date' => 'required|date|after_or_equal:activity_start_date',
            'location' => 'required|string|max:255',
            'thumbnail' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $activity = Activity::create($request->all());

        return response()->json($activity, 201);
    }

    public function show(Activity $activity)
    {
        return response()->json($activity);
    }

    public function update(Request $request, Activity $activity)
    {
        $validator = Validator::make($request->all(), [
            'organizer_id' => 'sometimes|required|integer|exists:organizers,organizer_id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'registration_start_date' => 'sometimes|required|date',
            'registration_end_date' => 'sometimes|required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'sometimes|required|date',
            'activity_end_date' => 'sometimes|required|date|after_or_equal:activity_start_date',
            'location' => 'sometimes|required|string|max:255',
            'thumbnail' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $activity->update($request->all());

        return response()->json($activity);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json(null, 204);
    }
}