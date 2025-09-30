<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * FUNGSI INDEX
     * Menampilkan semua data kegiatan.
     */
    public function index()
    {
        // Mengambil semua data dari model Activity, diurutkan dari yang terbaru
        $activities = Activity::latest()->get();
        
        // Mengembalikan response dalam format JSON
        return response()->json([
            'message' => 'Data kegiatan berhasil ditampilkan',
            'data' => $activities
        ], 200); // HTTP Status 200 OK
    }

    /**
     * FUNGSI STORE
     * Menyimpan data kegiatan baru.
     */
    public function store(Request $request)
    {
        // Menyiapkan aturan validasi untuk data yang masuk
        $validator = Validator::make($request->all(), [
            'organizer_id' => 'required|integer|exists:organizers,organizer_id',
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'activity_start_date' => 'required|date',
            'activity_end_date' => 'required|date|after_or_equal:activity_start_date',
            'location' => 'required|string|min:3|max:255',
            'thumbnail' => 'nullable|url',
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // HTTP Status 422 Unprocessable Entity
        }

        // Jika validasi berhasil, buat data baru
        $activity = Activity::create($request->all());

        return response()->json([
            'message' => 'Kegiatan baru berhasil dibuat',
            'data' => $activity
        ], 201); // HTTP Status 201 Created
    }

    /**
     * FUNGSI SHOW
     * Menampilkan detail satu kegiatan berdasarkan ID.
     */
    public function show(Activity $activity)
    {
        // Laravel secara otomatis akan mencari Activity berdasarkan ID yang ada di URL
        return response()->json([
            'message' => 'Detail kegiatan berhasil ditampilkan',
            'data' => $activity
        ], 200); // HTTP Status 200 OK
    }

    /**
     * FUNGSI UPDATE (PUT)
     * Mengupdate keseluruhan data kegiatan.
     */
    public function update(Request $request, Activity $activity)
    {
        // Validasi untuk PUT mengharuskan semua field diisi
        $validator = Validator::make($request->all(), [
            'organizer_id' => 'required|integer|exists:organizers,organizer_id',
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

        // Update data kegiatan yang ada dengan data baru
        $activity->update($request->all());

        return response()->json([
            'message' => 'Data kegiatan berhasil diperbarui',
            'data' => $activity
        ], 200); // HTTP Status 200 OK
    }

    /**
     * FUNGSI PATCH
     * Mengupdate sebagian data kegiatan.
     */
    public function patch(Request $request, Activity $activity)
    {
        // Validasi untuk PATCH bersifat 'sometimes', artinya hanya memvalidasi field yang dikirim
        $validator = Validator::make($request->all(), [
            'organizer_id' => 'sometimes|integer|exists:organizers,organizer_id',
            'title' => 'sometimes|string|min:3|max:255',
            'description' => 'sometimes|string|min:10',
            // ... (aturan validasi lainnya dibuat 'sometimes')
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update data kegiatan dengan data parsial yang dikirim
        $activity->update($request->all());

        return response()->json([
            'message' => 'Data kegiatan berhasil diperbarui sebagian',
            'data' => $activity
        ], 200); // HTTP Status 200 OK
    }

    /**
     * FUNGSI DESTROY
     * Menghapus data kegiatan.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json([
            'message' => 'Data kegiatan berhasil dihapus'
        ], 200); // HTTP Status 200 OK
    }
}