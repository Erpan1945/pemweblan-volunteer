<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityListController;
use App\Http\Controllers\Api\ActivityListController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\VolunteerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ActivityRequestController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\FollowingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\EnrollmentController;

Route::post('/register/volunteer', [AuthController::class, 'registerVolunteer']);
Route::post('/register/organizer', [AuthController::class, 'registerOrganizer']);
Route::post('/login', [AuthController::class, 'login']);

// --- Rute yang Memerlukan Autentikasi (WAJIB LOGIN DENGAN TOKEN) ---
Route::middleware('auth:api')->group(function () {
    
    // Semua rute profil disatukan di sini
    // Semua rute profil disatukan di sini
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
    
    // Rute Logout
    // Rute Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rute untuk Permohonan Kegiatan (Activity Request)
    
    // Rute Khusus Admin
    Route::middleware('admin')->group(function() {
        Route::apiResource('admins', AdminController::class);
        // Admin bisa melakukan segalanya kecuali melihat daftar publik (index & show)
        Route::apiResource('organizers', OrganizerController::class)->except(['index', 'show']);
        // Admin bisa melakukan segalanya kecuali melihat daftar publik (index & show)
        Route::apiResource('organizers', OrganizerController::class)->except(['index', 'show']);
        Route::apiResource('volunteers', VolunteerController::class);
    });
    
});

Route::prefix('activity_request')->group(function () {
    Route::post('/', [ActivityRequestController::class, 'store']);
    Route::get('/', [ActivityRequestController::class, 'index']);
    Route::get('/mine', [ActivityRequestController::class, 'mine']);
    Route::get('/{id}', [ActivityRequestController::class, 'show']);
    Route::put('/{id}', [ActivityRequestController::class, 'update']);
    Route::delete('/{id}', [ActivityRequestController::class, 'destroy']);
    
    // Admin untuk Menyetujui/Menolak
    Route::patch('/{id}/approve', [ActivityRequestController::class, 'approve'])->middleware('admin');
    Route::patch('/{id}/reject', [ActivityRequestController::class, 'reject'])->middleware('admin');
});

Route::prefix('activities')->controller(ActivityController::class)->group(function () {
    Route::get('/mine', 'mine')->name('activities.mine');
    Route::patch('/{activity}/schedule', 'schedule')->name('activities.schedule');
    Route::patch('/{activity}/approve', 'approve')->name('activities.approve')->middleware('admin'); // Hanya admin
    Route::patch('/{activity}/reject', 'reject')->name('activities.reject')->middleware('admin');   // Hanya admin
});

// Rute CRUD standar yang dibuat otomatis
Route::apiResource('activities', ActivityController::class);
Route::apiResource('organizers', OrganizerController::class)->only(['index', 'show']); // Hanya index & show yang publik
Route::apiResource('volunteers', VolunteerController::class)->only(['index', 'show']); // Hanya index & show yang publik

Route::get('/user', [UserController::class, 'show']);

Route::get('/following', [FollowingController::class, 'index']); 
Route::get('/follower/{organizer}', [FollowingController::class, 'showFollower']); //menampilkan detail pengikut suatu penyelenggara
Route::get('/following/{volunteer}', [FollowingController::class, 'show']); //menampilkan detail penyelenggara yang diikuti oleh volunteer
Route::post('/following', [FollowingController::class, 'store']); //memfollow penyelenggara
Route::patch('/following/{organizer}/notifications', [FollowingController::class, 'update']); //update notifikasi
Route::delete('/following/{organizer}', [FollowingController::class, 'destroy']); //batal follow

// Route::prefix('activity_request')->group(function () {
//     Route::post('/', [ActivityRequestController::class, 'store']);
//     Route::get('/', [ActivityRequestController::class, 'index']);
//     Route::get('/mine', [ActivityRequestController::class, 'mine']);
//     Route::get('/{id}', [ActivityRequestController::class, 'show']);
//     Route::put('/{id}', [ActivityRequestController::class, 'update']);
//     Route::delete('/{id}', [ActivityRequestController::class, 'destroy']);
//     Route::patch('/{id}/approve', [ActivityRequestController::class, 'approve']);
//     Route::patch('/{id}/reject', [ActivityRequestController::class, 'reject']);
// });

// // --- USER (umum)
// Route::get('/users', [UserController::class, 'index']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);

// // --- ADMIN
// Route::get('/admins', [AdminController::class, 'index']);
// Route::get('/admins/{id}', [AdminController::class, 'show']);
// Route::post('/admins', [AdminController::class, 'store']);
// Route::put('/admins/{id}', [AdminController::class, 'update']);
// Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

// // --- ORGANIZER
// Route::get('/organizers', [OrganizerController::class, 'index']);
// Route::get('/organizers/{id}', [OrganizerController::class, 'show']);
// Route::post('/organizers', [OrganizerController::class, 'store']);
// Route::put('/organizers/{id}', [OrganizerController::class, 'update']);
// Route::delete('/organizers/{id}', [OrganizerController::class, 'destroy']);

// // --- VOLUNTEER
// Route::get('/volunteers', [VolunteerController::class, 'index']);
// Route::get('/volunteers/{id}', [VolunteerController::class, 'show']);
// Route::post('/volunteers', [VolunteerController::class, 'store']);
// Route::put('/volunteers/{id}', [VolunteerController::class, 'update']);
// Route::delete('/volunteers/{id}', [VolunteerController::class, 'destroy']);

// Rute untuk mendapatkan informasi user berdasarkan ID (contoh)
Route::get('/user/{id}', [UserController::class, 'show']);
