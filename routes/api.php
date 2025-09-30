<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\VolunteerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ActivityRequestController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\FollowingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EnrollmentController;


// --- Rute Autentikasi (Publik) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// --- Rute yang Memerlukan Autentikasi (WAJIB LOGIN DENGAN TOKEN) ---
Route::middleware('auth:api')->group(function () {
    
    // Semua rute profil disatukan di sini
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
    
    // Rute Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rute untuk Permohonan Kegiatan (Activity Request)
    Route::prefix('activity_request')->group(function () {
        Route::post('/', [ActivityRequestController::class, 'store']);
        Route::get('/', [ActivityRequestController::class, 'index'])->middleware('admin');
        Route::get('/mine', [ActivityRequestController::class, 'mine']);
        Route::get('/{id}', [ActivityRequestController::class, 'show']);
        Route::put('/{id}', [ActivityRequestController::class, 'update']);
        Route::delete('/{id}', [ActivityRequestController::class, 'destroy']);
        
        // Aksi Admin untuk Menyetujui/Menolak
        Route::patch('/{id}/approve', [ActivityRequestController::class, 'approve'])->middleware('admin');
        Route::patch('/{id}/reject', [ActivityRequestController::class, 'reject'])->middleware('admin');
    });

    // Rute Khusus Admin
    Route::middleware('admin')->group(function() {
        Route::apiResource('admins', AdminController::class);
        // Admin bisa melakukan segalanya kecuali melihat daftar publik (index & show)
        Route::apiResource('organizers', OrganizerController::class)->except(['index', 'show']);
        Route::apiResource('volunteers', VolunteerController::class);
    });
    
    // Rute Mengikuti Penyelenggara (Following)
    Route::get('/following', [FollowingController::class, 'index']); 
    Route::get('/follower/{organizer}', [FollowingController::class, 'showFollower']);
    Route::get('/following/{volunteer}', [FollowingController::class, 'show']);
    Route::post('/following', [FollowingController::class, 'store']);
    Route::patch('/following/{organizer}/notifications', [FollowingController::class, 'update']);
    Route::delete('/following/{organizer}', [FollowingController::class, 'destroy']);
});


// --- Rute Publik (Tidak Perlu Login) ---

// Rute untuk Kegiatan (Activities)
// Rute spesifik (yang punya kata unik seperti 'mine', 'schedule') harus di atas rute umum `apiResource`
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

// Rute untuk mendapatkan informasi user berdasarkan ID (contoh)
Route::get('/user/{id}', [UserController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::get('/enrollments', [EnrollmentController::class, 'index']);
    Route::get('/enrollments/{id}', [EnrollmentController::class, 'show']);
    Route::post('/enrollments', [EnrollmentController::class, 'store']);
    Route::put('/enrollments/{id}', [EnrollmentController::class, 'update']);
    Route::patch('/enrollments/{id}', [EnrollmentController::class, 'update']);
    Route::patch('/enrollments/{id}/status', [EnrollmentController::class, 'updateStatus']);
    Route::delete('/enrollments/{id}', [EnrollmentController::class, 'destroy']);

    // helper routes
    Route::get('/user/{id}/enrollments', [EnrollmentController::class, 'getByUser']);
    Route::get('/activity/{id}/enrollments', [EnrollmentController::class, 'getByActivity']);
});