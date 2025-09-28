<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Organizer;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validasi data umum dan peran (role)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['volunteer', 'organizer'])], // Role harus 'volunteer' atau 'organizer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = $request->input('role');
        $userModel = null;
        $message = '';

        // Tentukan model dan pesan berdasarkan peran yang dipilih
        if ($role === 'volunteer') {
            // Validasi email unik untuk tabel volunteers
            $request->validate(['email' => 'unique:volunteers']);
            $userModel = new Volunteer();
            $message = 'Registrasi Volunteer berhasil';
        } elseif ($role === 'organizer') {
            // Validasi email unik untuk tabel organizers
            $request->validate(['email' => 'unique:organizers']);
            $userModel = new Organizer();
            $message = 'Registrasi Organizer berhasil';
        }

        // Buat pengguna baru
        $user = $userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login dan dapatkan token
        $token = Auth::guard('api')->login($user);
        return $this->respondWithToken($token, $message, 201);
    }

    /**
     * Metode login universal yang akan mengecek semua tipe user.
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Daftar model pengguna yang akan kita periksa
        $userModels = [
            Volunteer::class,
            Organizer::class,
            Admin::class,
        ];

        $credentials = $request->only('email', 'password');
        $foundUser = null;

        // Loop untuk mencari pengguna di setiap tabel
        foreach ($userModels as $model) {
            $user = $model::where('email', $credentials['email'])->first();

            // Jika user ditemukan di tabel saat ini DAN password-nya cocok
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $foundUser = $user;
                break; // Hentikan loop jika sudah ditemukan
            }
        }

        // Jika setelah dicek semua tabel pengguna tidak ditemukan atau password salah
        if (! $foundUser) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        // Jika pengguna ditemukan, buat token JWT untuknya
        $token = Auth::guard('api')->login($foundUser);
        
        return $this->respondWithToken($token, 'Login berhasil');
    }

    public function profile()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        try {
            // Mencoba untuk membuat token saat ini tidak valid (blacklist)
            Auth::guard('api')->logout();
            
            return response()->json(['message' => 'Successfully logged out']);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            
            // Jika terjadi error saat proses invalidasi token
            return response()->json([
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }   

    /**
     * Helper function untuk format response token
     */
    protected function respondWithToken($token, $message, $status = 200)
    {
        return response()->json([
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ], $status);
    }
}