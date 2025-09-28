<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Resources\AdminResource;
use App\Http\Resources\OrganizerResource;
use App\Http\Resources\VolunteerResource;

class ProfileController extends Controller
{
    // GET /api/profile
    public function show(Request $request)
    {
        // Dapatkan user yang sedang login
        $user = $request->user();

        // Deteksi tipe user dan bungkus dengan Resource yang sesuai
        if ($user instanceof \App\Models\Admin) {
            return new AdminResource($user);
        }
        
        if ($user instanceof \App\Models\Organizer) {
            return new OrganizerResource($user);
        }
        
        if ($user instanceof \App\Models\Volunteer) {
            return new VolunteerResource($user);
        }

        // Fallback jika tipe user tidak dikenali (seharusnya tidak terjadi)
        return response()->json($user);
    }

    // PUT /api/profile
    public function update(Request $request)
    {
        $user = $request->user();
        $tableName = '';
        $primaryKeyName = '';
        $specificRules = [];

        // 1. Deteksi tipe user dan siapkan variabel yang benar
        if ($user instanceof \App\Models\Volunteer) {
            $tableName = 'volunteers';
            $primaryKeyName = $user->getKeyName(); // Mendapatkan 'volunteer_id'
            // Volunteer tidak punya 'phone', jadi kita tidak tambahkan aturan
        } elseif ($user instanceof \App\Models\Organizer) {
            $tableName = 'organizers';
            $primaryKeyName = $user->getKeyName(); // Mendapatkan 'organizer_id'
            // Organizer punya 'phone_number', jadi kita tambahkan aturannya
            $specificRules = [
                'phone_number' => 'nullable|string|max:20'
            ];
        } elseif ($user instanceof \App\Models\Admin) {
            $tableName = 'admins';
            $primaryKeyName = $user->getKeyName(); // Mendapatkan 'admin_id'
            // Admin tidak punya 'phone'
        }

        // 2. Gabungkan aturan umum dan spesifik
        $rules = array_merge([
            'name' => 'required|string|max:255',
            // Aturan 'unique' sekarang dinamis berdasarkan tipe user
            'email' => 'required|email|max:255|unique:' . $tableName . ',email,' . $user->getKey(),
        ], $specificRules);
        
        // 3. Lakukan validasi
        $validated = $request->validate($rules);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // PATCH /api/profile/password
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    // POST /api/profile/avatar
    public function updateAvatar(Request $request)
    {
        $user = $request->user();

        // Hanya Organizer yang bisa update logo/avatar
        if ($user instanceof \App\Models\Organizer) {
            $validated = $request->validate([
                'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $path = $validated['avatar']->store('logos', 'public');

            // Update kolom 'logo', bukan 'avatar'
            $user->update([
                'logo' => $path,
            ]);

            return response()->json([
                'message' => 'Logo updated successfully',
                'logo_url' => asset('storage/' . $path),
            ]);
        }

        // Jika user bukan Organizer, kirim pesan error
        return response()->json([
            'message' => 'This feature is not available for your user type.'
        ], 403); // 403 Forbidden
    }
}
