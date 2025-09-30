<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Organizer;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * FUNGSI INDEX (Publik)
     * Menampilkan semua data kegiatan.
     */
    public function index()
    {
        $activities = Activity::latest()->get();
        return response()->json([
            'message' => 'Data kegiatan berhasil ditampilkan',
            'data' => $activities
        ], 200);
    }

    /**
     * FUNGSI STORE (Khusus Organizer)
     * Menyimpan data kegiatan baru.
     */
    public function store(Request $request)
    {
        // Dapatkan user organizer yang sedang login
        $organizer = auth('organizer')->user();

        // Cek apakah user adalah Organizer
        if (!$organizer instanceof Organizer) {
            return response()->json(['message' => 'Hanya organizer yang dapat membuat kegiatan'], 403);
        }

        // Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            // 'organizer_id' dihapus karena akan diisi otomatis
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'required|date',
            'activity_end_date' => 'required|date|after_or_equal:activity_start_date',
            'location' => 'required|string|min:3|max:255',
            'thumbnail' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // Gabungkan data tervalidasi dengan ID organizer yang login
        $data = array_merge($validator->validated(), ['organizer_id' => $organizer->organizer_id]);

        $activity = Activity::create($data);

        return response()->json([
            'message' => 'Kegiatan baru berhasil dibuat',
            'data' => $activity
        ], 201);
    }

    /**
     * FUNGSI SHOW (Publik)
     * Menampilkan detail satu kegiatan berdasarkan ID.
     */
    public function show(Activity $activity)
    {
        return response()->json([
            'message' => 'Detail kegiatan berhasil ditampilkan',
            'data' => $activity
        ], 200);
    }

    /**
     * FUNGSI UPDATE (Khusus Organizer Pemilik & Admin)
     * Mengupdate keseluruhan data kegiatan.
     */
    public function update(Request $request, Activity $activity)
    {
        // Dapatkan user yang sedang login dari guard default
        $user = Auth::user();

        // Cek apakah user adalah Admin atau Organizer pemilik
        $isOwner = ($user instanceof Organizer && $user->organizer_id === $activity->organizer_id);
        $isAdmin = ($user instanceof Admin);

        if (!$isOwner && !$isAdmin) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengubah kegiatan ini'], 403);
        }
        
        // Lanjutkan dengan validasi dan update
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            // ... (validasi lainnya)
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $activity->update($request->all());

        return response()->json([
            'message' => 'Data kegiatan berhasil diperbarui',
            'data' => $activity
        ], 200);
    }

    /**
     * FUNGSI PATCH (Khusus Organizer Pemilik & Admin)
     * Mengupdate sebagian data kegiatan.
     */
    public function patch(Request $request, Activity $activity)
    {
        $user = Auth::user();

        $isOwner = ($user instanceof Organizer && $user->organizer_id === $activity->organizer_id);
        $isAdmin = ($user instanceof Admin);

        if (!$isOwner && !$isAdmin) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengubah kegiatan ini'], 403);
        }
        
        // Update dengan data parsial yang dikirim
        $activity->update($request->all());

        return response()->json([
            'message' => 'Data kegiatan berhasil diperbarui sebagian',
            'data' => $activity
        ], 200);
    }

    /**
     * FUNGSI DESTROY (Khusus Organizer Pemilik & Admin)
     * Menghapus data kegiatan.
     */
    public function destroy(Activity $activity)
    {
        $user = Auth::user();

        $isOwner = ($user instanceof Organizer && $user->organizer_id === $activity->organizer_id);
        $isAdmin = ($user instanceof Admin);

        if (!$isOwner && !$isAdmin) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk menghapus kegiatan ini'], 403);
        }

        $activity->delete();

        return response()->json(['message' => 'Data kegiatan berhasil dihapus'], 200);
    }
}