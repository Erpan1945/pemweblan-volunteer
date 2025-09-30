<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Models\Organizer;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    //

    public function index(){
        
        $followings = DB::table('following')->get();        
        return response()->json([
            'message' => 'daftar following',
            'data' => $followings
        ]);
    }

    public function showFollower(Organizer $organizer){
        $organizer->load('volunteers');
        return response()->json([
            'message' => 'daftar pengikut organizer tertentu',
            'data' => $organizer
        ]);
    }

    public function show(Volunteer $volunteer){     
        $volunteer->load('organizers');

        return response()->json([
            'message' => 'daftar penyelenggara yang diikuti',
            'data' => $volunteer
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([            
            'organizer_id' => 'required|exists:organizers,organizer_id',
            'notification' => 'required|boolean',
        ]);

        $volunteer = auth()->user();

        if(!$volunteer instanceof \App\Models\Volunteer){
            return response()->json([
                'message' => 'Hanya volunteer yang bisa melakukan follow'
            ],403);
        }

        $organizer = Organizer::findOrFail($validated['organizer_id']);

        $volunteer->organizers()->syncWithoutDetaching([
            $validated['organizer_id'] => ['notification' => $validated['notification']]
        ]);

        $pivot = $volunteer->organizers()
                ->find($organizer->organizer_id)?->pivot; 

        return response()->json([
            'message' => 'Berhasil Follow Penyelenggara',
            'data' => $pivot
        ], 201);
    }

    public function update(Request $request, Organizer $organizer){
        $validated = $request->validate([            
            'notification' => 'required|boolean',
        ]); 

        $volunteer = auth()->user();
        if(!$volunteer instanceof \App\Models\Volunteer){
            return response()->json([
                'message' => 'Hanya volunteer yang bisa melakukan mengubah setelan notifikasi'
            ],403);
        }

        $volunteer = Volunteer::findOrFail($validated['volunteer_id']);
        $updated = $volunteer->organizers()
            ->updateExistingPivot($organizer->organizer_id, [
                'notification' => $validated['notification']
            ]);
        
        if($updated === 0) {
            return response()->json([
                'message' => 'Anda belum follow organizer ini'
            ],403);
        }

        $pivot = $volunteer->organizers()
                ->find($organizer->organizer_id)?->pivot;              

        return response()->json([
            'message' => 'Notification berhasil diperbarui',
            'data' => $pivot
        ]);
    }

    public function destroy(Organizer $organizer){
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:volunteers,volunteer_id',
        ]);

        $volunteer = auth()->user();
        if(!$volunteer instanceof \App\Models\Volunteer){
            return response()->json([
                'message' => 'Hanya volunteer yang bisa melakukan mengubah setelan notifikasi'
            ],403);
        }

        $deleted = $volunteer->organizers()->detach($organizer->organizer_id);

        if($deleted === 0){
            return response()->json([
                'message' => 'Gagal unfollow: Anda belum follow organizer ini'
            ],403);
        }
        
        return response()->json([
            'message' => 'Berhasil Unfollow Organizer'
        ]);
    }

}
