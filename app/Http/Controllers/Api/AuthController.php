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
            'province' => 'nullable|string',
            'city' => 'nullable|string',
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
            'province' => $request->province,
            'city' => $request->city,
        ]);

        $token = Auth::guard('volunteer')->login($user);
        return $this->respondWithToken($token, 'Registrasi Volunteer berhasil', 201);
    }

    public function registerOrganizer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:organizers',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'date_of_establishment' => 'nullable|date',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'website' => 'nullable|string',
            'instagram' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Organizer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'date_of_establishment' => $request->date_of_establishment,
            'description' => $request->description,
            'logo' => $request->logo,
            'website' => $request->website,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'province' => $request->province,
            'city' => $request->city,
        ]);

        $token = Auth::guard('organizer')->login($user);
        return $this->respondWithToken($token, 'Registrasi Organizer berhasil', 201);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        $guards = [
            'volunteer' => Volunteer::class,
            'organizer' => Organizer::class,
            'admin' => Admin::class,
        ];

        foreach ($guards as $guard => $model) {
            $user = $model::where('email', $credentials['email'])->first();

            if ($user && Hash::check($credentials['password'], $user->password)) {
                $token = Auth::guard($guard)->login($user);
                return $this->respondWithToken($token, 'Login berhasil sebagai ' . $guard, 200);
            }
        }

        return response()->json(['message' => 'Email atau password salah.'], 401);
    }

    public function logout(){
         $guards = ['volunteer', 'organizer', 'admin'];
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                try{
                    Auth::guard($guard)->logout();
                    return response()->json(['message' => 'Successfully Logged Out']);
                } catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
                    return response()->json(['errror' => 'Failed to logout, token invalid or missing'], 401);
                }
            }
        }
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