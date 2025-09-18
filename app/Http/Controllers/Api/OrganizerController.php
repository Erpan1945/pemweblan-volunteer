<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        return response()->json(Organizer::all(), 200);
    }

    public function show($id)
    {
        $organizer = Organizer::find($id);

        if (!$organizer) {
            return response()->json(['message' => 'Organizer not found'], 404);
        }

        return response()->json($organizer, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $organizer = Organizer::create($request->all());

        return response()->json([
            'message' => 'Organizer created successfully',
            'data' => $organizer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $organizer = Organizer::find($id);

        if (!$organizer) {
            return response()->json(['message' => 'Organizer not found'], 404);
        }

        $organizer->update($request->all());

        return response()->json([
            'message' => 'Organizer updated successfully',
            'data' => $organizer
        ], 200);
    }

    public function destroy($id)
    {
        $organizer = Organizer::find($id);

        if (!$organizer) {
            return response()->json(['message' => 'Organizer not found'], 404);
        }

        $organizer->delete();

        return response()->json(['message' => 'Organizer deleted successfully'], 200);
    }
}
