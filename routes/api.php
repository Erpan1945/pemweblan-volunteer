<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;
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
use App\Http\Controllers\Api\ReviewController;

Route::post('/register/volunteer', [AuthController::class, 'registerVolunteer']);
Route::post('/register/organizer', [AuthController::class, 'registerOrganizer']);
Route::post('/login', [AuthController::class, 'login']);

// --- Rute yang Memerlukan Autentikasi (WAJIB LOGIN DENGAN TOKEN) ---
Route::middleware('auth:organizer,volunteer,admin')->group(function () {    
    // Route LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Route PROFIL
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);

    Route::get('/following', [FollowingController::class, 'index']); 
    Route::get('/follower/{organizer}', [FollowingController::class, 'showFollower']); 
    Route::get('/following/{volunteer}', [FollowingController::class, 'show']); 
    Route::post('/following', [FollowingController::class, 'store']); 
    Route::patch('/following/{organizer}/notifications', [FollowingController::class, 'update']); 
    Route::delete('/following/{organizer}', [FollowingController::class, 'destroy']); 
    
    // Route khusus VOLUNTEERS
    Route::middleware('auth:volunteer')->group(function() {        
        //Route MANAJEMEN DAFTAR KEGIATAN
        Route::post('/activity_lists', [ActivityListController::class, 'store']);
        Route::get('/volunteers/{volunteer}/activity_lists', [ActivityListController::class, 'index']);
        Route::post('/activities/{activity}/activity_lists',  [ActivityListController::class, 'save']);
        Route::get('/activity_lists/{activity_list}', [ActivityListController::class, 'show']);
        Route::delete('/activity_lists/{activity_list}', [ActivityListController::class, 'destroy']);
        Route::delete('/activity_lists/{activity_list}/activities/{activity}', [ActivityListController::class, 'remove']);
        Route::put('/activities/{activity}/activity_lists', [ActivityListController::class, 'update']);
        Route::put('/activity_lists/{activity_list}/name', [ActivityListController::class, 'rename']);
    });
    
    // Rute untuk pendaftaran kegiatan
    Route::get('/enrollments', [EnrollmentController::class, 'index']); // GET semua pendaftaran
    Route::get('/enrollments/{id}', [EnrollmentController::class, 'show']); // GET detail
    Route::post('/enrollments', [EnrollmentController::class, 'store']); // POST daftar kegiatan
    Route::put('/enrollments/{id}', [EnrollmentController::class, 'update']); // PUT update
    Route::patch('/enrollments/{id}', [EnrollmentController::class, 'update']); // PATCH update partial
    Route::delete('/enrollments/{id}', [EnrollmentController::class, 'destroy']); // DELETE pendaftaran
    Route::patch('/enrollments/{id}/status', [EnrollmentController::class, 'updateStatus']); 
    Route::get('/user/{volunteer}/enrollments', [EnrollmentController::class, 'getByUser']); 
    Route::get('/activity/{activity}/enrollments', [EnrollmentController::class, 'getByActivity']); 
    
    // Rute untuk publikasi kegiatan
    Route::post('activities', [ActivityController::class, 'store']);
    Route::put('activities/{activity}', [ActivityController::class, 'update']);
    Route::patch('activities/{activity}', [ActivityController::class, 'patch']);
    Route::delete('activities/{activity}', [ActivityController::class, 'destroy']);

    // Rute untuk permohonan kegiatan
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
    

    // Rute Khusus Admin
    Route::middleware('auth:admin')->group(function() {
        Route::apiResource('admins', AdminController::class);
        // Admin bisa melakukan segalanya kecuali melihat daftar publik (index & show)
        Route::apiResource('organizers', OrganizerController::class)->except(['index', 'show']);
        // Admin bisa melakukan segalanya kecuali melihat daftar publik (index & show)
        Route::apiResource('organizers', OrganizerController::class)->except(['index', 'show']);
        Route::apiResource('volunteers', VolunteerController::class);
    });    


    //Rute CRUD Review
    Route::get('/review', [ReviewController::class, 'index']);
    Route::post('/review', [ReviewController::class, 'store']); //buat review
    Route::delete('/review/{id}', [ReviewController::class, 'destroy']);
    Route::get('/review/{id}', [ReviewController::class, 'filterOne']); //tampil satu2
    Route::put('/review/{id}', [ReviewController::class, 'update']);
    Route::get('/review/{activity_id}', [ReviewController::class, 'filterActivity']); //tampil dari aktivitas

    // Rute CRUD standar yang dibuat otomatis
    Route::apiResource('activities', ActivityController::class);
    Route::apiResource('organizers', OrganizerController::class)->only(['index', 'show']); // Hanya index & show yang publik
    Route::apiResource('volunteers', VolunteerController::class)->only(['index', 'show']); // Hanya index & show yang publik

    Route::get('/user', [UserController::class, 'show']);

    // Rute untuk mendapatkan informasi user berdasarkan ID (contoh)
    Route::get('/user/{id}', [UserController::class, 'show']);

});

<<<<<<< HEAD
//Rute CRUD Review

Route::middleware(['auth:volunteer'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

Route::middleware(['auth:organizer'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{id}', [ReviewController::class, 'filterOne']);
    Route::get('/reviews/activity/{activity_id}', [ReviewController::class, 'filterActivity']);
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{id}', [ReviewController::class, 'filterOne']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);
});

Route::get('/reviews/activity/{activity_id}', [ReviewController::class, 'filterActivity']);
Route::get('/reviews/{id}', [ReviewController::class, 'filterOne']);


// Rute CRUD standar yang dibuat otomatis
Route::apiResource('activities', ActivityController::class);
Route::apiResource('organizers', OrganizerController::class)->only(['index', 'show']); // Hanya index & show yang publik
Route::apiResource('volunteers', VolunteerController::class)->only(['index', 'show']); // Hanya index & show yang publik

Route::get('/user', [UserController::class, 'show']);


// Rute untuk mendapatkan informasi user berdasarkan ID (contoh)
Route::get('/user/{id}', [UserController::class, 'show']);

=======
//Publikasi Kegiatan (publik)
Route::get('activities', [ActivityController::class, 'index']);
Route::get('activities/{activity}', [ActivityController::class, 'show']);
>>>>>>> e6178b2fb25b9748dbc83f44ec0ddacd714e49f7
