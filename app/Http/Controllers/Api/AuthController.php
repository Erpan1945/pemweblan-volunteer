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


class AuthController extends Controller
{

    public function registerVolunteer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:volunteers',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'nullable|string|in:male,female,other',
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Volunteer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        $token = Auth::guard('api')->login($user);
        return $this->respondWithToken($token, 'Registrasi Volunteer berhasil', 201);
    }

    public function registerOrganizer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:organizers',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Organizer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        $token = Auth::guard('api')->login($user);
        return $this->respondWithToken($token, 'Registrasi Organizer berhasil', 201);
    }

    public function login(Request $request)
    {
        // ... (kode login universal tidak perlu diubah)
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userModels = [Volunteer::class, Organizer::class, Admin::class];
        $credentials = $request->only('email', 'password');
        $foundUser = null;

        foreach ($userModels as $model) {
            $user = $model::where('email', $credentials['email'])->first();
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $foundUser = $user;
                break;
            }
        }

        if (!$foundUser) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $token = Auth::guard('api')->login($foundUser);
        return $this->respondWithToken($token, 'Login berhasil');
    }

    protected function respondWithToken($token, $message, $status = 200)
    {
        return response()->json([
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ], $status);
    }

    // ... (metode profile, logout, dan respondWithToken tetap sama)
}