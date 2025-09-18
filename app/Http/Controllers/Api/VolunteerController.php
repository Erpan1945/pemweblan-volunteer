<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index()
    {
        return response()->json(Volunteer::all(), 200);
    }

    public function show($id)
    {
        $volunteer = Volunteer::find($id);

        if (!$volunteer) {
            return response()->json(['message' => 'Volunteer not found'], 404);
        }

        return response()->json($volunteer, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $volunteer = Volunteer::create($request->all());

        return response()->json([
            'message' => 'Volunteer created successfully',
            'data' => $volunteer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $volunteer = Volunteer::find($id);

        if (!$volunteer) {
            return response()->json(['message' => 'Volunteer not found'], 404);
        }

        $volunteer->update($request->all());

        return response()->json([
            'message' => 'Volunteer updated successfully',
            'data' => $volunteer
        ], 200);
    }

    public function destroy($id)
    {
        $volunteer = Volunteer::find($id);

        if (!$volunteer) {
            return response()->json(['message' => 'Volunteer not found'], 404);
        }

        $volunteer->delete();

        return response()->json(['message' => 'Volunteer deleted successfully'], 200);
    }
}
