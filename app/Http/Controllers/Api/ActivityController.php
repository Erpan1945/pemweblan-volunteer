<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ActivityResource;

class ActivityController extends Controller
{
    // GET /api/activities
    // GET /api/activities
    public function index()
    {
        $activities = Activity::with('organizer')->get();

        $result = $activities->map(function ($activity) {
            return [
                'activity_id'              => $activity->activity_id,
                'title'                    => $activity->title,
                'description'              => $activity->description,
                'registration_start_date'  => $activity->registration_start_date,
                'registration_end_date'    => $activity->registration_end_date,
                'activity_start_date'      => $activity->activity_start_date,
                'activity_end_date'        => $activity->activity_end_date,
                'location'                 => $activity->location,
                'thumbnail'                => $activity->thumbnail,
                'organizer'                => $activity->organizer ? $activity->organizer->name : null,
                'created_at'               => $activity->created_at,
                'updated_at'               => $activity->updated_at,
            ];
        });

        return response()->json($result, 200);
    }

    // GET /api/activities/{id}
    public function show($id)
    {
        $activity = Activity::with('organizer')->find($id);

        if (! $activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }

        $result = [
            'activity_id'              => $activity->activity_id,
            'title'                    => $activity->title,
            'description'              => $activity->description,
            'registration_start_date'  => $activity->registration_start_date,
            'registration_end_date'    => $activity->registration_end_date,
            'activity_start_date'      => $activity->activity_start_date,
            'activity_end_date'        => $activity->activity_end_date,
            'location'                 => $activity->location,
            'thumbnail'                => $activity->thumbnail,
            'organizer'                => $activity->organizer ? $activity->organizer->name : null,
            'created_at'               => $activity->created_at,
            'updated_at'               => $activity->updated_at,
        ];

        return response()->json($result, 200);
    }


    // POST /api/activities
    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->validated());
        return response()->json($activity, 201);
    }

    // PUT/PATCH /api/activities/{id}
    public function update(UpdateActivityRequest $request, $id)
    {
        $activity = Activity::find($id);
        if (! $activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
        $activity->update($request->validated());
        return response()->json($activity, 200);
    }

    // DELETE /api/activities/{id}
    public function destroy($id)
    {
        $activity = Activity::find($id);
        if (! $activity) {
            return response()->json(['message' => 'Activity not found'], 404);
        }
        $activity->delete();
        return response()->json(['message' => 'Activity deleted'], 200);
    }
}
