<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityList;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class ActivityListController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // ambil volunteer yang login
        $volunteer = auth('volunteer')->user();

        if (!$volunteer) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // buat list
        $list = ActivityList::create([
            'volunteer_id' => $volunteer->volunteer_id,
            'name' => $validated['name']
        ]);

        return response()->json([
            'message' => "Daftar Aktivitas berhasil dibuat",
            'data' => $list
        ], 201);
    }

    public function index()
    {
        /** @var \App\Models\Volunteer $volunteer */
        $volunteer = auth('volunteer')->user();
        
        if (!$volunteer) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $lists = $volunteer->activityLists()->with('activities')->get();

        return response()->json([
            'message' => 'Tampilan Daftar milik Volunteer',
            'data' => $lists
        ], 200);
    }


    public function save(Request $request, Activity $activity){
        $validated = $request->validate([
            'list_id' => 'required|exists:activity_lists,list_id',
        ]);
            
            $list = ActivityList::findOrFail($validated['list_id']);

            $list->activities()->syncWithoutDetaching([$activity->activity_id]);

            return response()->json([
                'message' => 'Activity berhasil disimpan ke Daftar',
                'data'    => $list->name,
            ], 201);
    }

    public function show(ActivityList $activity_list){
        $activity_list->load('activities');

        return response()->json([
            'message' => 'List Aktivitas pada Daftar',
            'data' => $activity_list
        ], 200);
    }

    public function destroy(ActivityList $activity_list){
        $activity_list->delete();

        return response()->json([
            'message' => 'Daftar berhasil dihapus'
        ], 200);
    }

    public function remove(ActivityList $activity_list, Activity $activity){
        $activity_list->activities()->detach($activity->activity_id);

        return response()->json([
            'message' => 'Activity berhasil dihapus dari list'
        ], 200);
    }

    public function update(Request $request, Activity $activity){
        $validated = $request->validate([
            'list_id' => 'required|exists:activity_lists,list_id',
        ]);

        $activity->activity_lists()->sync([$validated['list_id']]);

        return response()->json([
            'message' => 'Activity berhasil dipindahkan ke list baru',
            'list_id' => $validated['list_id']
        ], 200);
    }

    public function rename(Request $request, ActivityList $activity_list){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $activity_list->update(['name' => $validated['name']]);

        return response()->json([
            'message' => 'Nama list berhasil diperbarui',
            'data'    => $activity_list
        ], 200);
    }
}
