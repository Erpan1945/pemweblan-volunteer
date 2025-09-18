<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan semua admin
    public function index()
    {
        return response()->json(Admin::all(), 200);
    }

    // Menampilkan detail admin berdasarkan id
    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        return response()->json($admin, 200);
    }

    // Tambah admin baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $admin = Admin::create($request->all());

        return response()->json([
            'message' => 'Admin created successfully',
            'data' => $admin
        ], 201);
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->update($request->all());

        return response()->json([
            'message' => 'Admin updated successfully',
            'data' => $admin
        ], 200);
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully'], 200);
    }
}
