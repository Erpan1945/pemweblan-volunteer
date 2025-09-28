
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityRequestController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\VolunteerController;
use App\Http\Controllers\Api\FollowingController;

// Route::get('activities', [ActivityController::class, 'index']);
// Route::get('activities/{id}', [ActivityController::class, 'show']);
// Route::post('activities', [ActivityController::class, 'store']);
// Route::put('activities/{id}', [ActivityController::class, 'update']);
// Route::patch('activities/{id}', [ActivityController::class, 'update']);
// Route::delete('activities/{id}', [ActivityController::class, 'destroy']);

Route::prefix('activities')->group(function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::get('/{id}', [ActivityController::class, 'show']);
    Route::post('/', [ActivityController::class, 'store']);
    Route::put('/{id}', [ActivityController::class, 'update']);
    Route::patch('/{id}', [ActivityController::class, 'update']);
    Route::delete('/{id}', [ActivityController::class, 'destroy']);
});

Route::get('test', function () {
    return ['message' => 'ok'];
});

Route::prefix('activity_request')->group(function () {
    Route::post('/', [ActivityRequestController::class, 'store']);
    Route::get('/', [ActivityRequestController::class, 'index']);
    Route::get('/mine', [ActivityRequestController::class, 'mine']);
    Route::get('/{id}', [ActivityRequestController::class, 'show']);
    Route::put('/{id}', [ActivityRequestController::class, 'update']);
    Route::delete('/{id}', [ActivityRequestController::class, 'destroy']);
    Route::patch('/{id}/approve', [ActivityRequestController::class, 'approve']);
    Route::patch('/{id}/reject', [ActivityRequestController::class, 'reject']);
});

Route::prefix('profiles')->group(function () {
    Route::get('/', [ProfileController::class, 'index']);       
    Route::get('/{id}', [ProfileController::class, 'show']);    
    Route::post('/', [ProfileController::class, 'store']);      
    Route::put('/{id}', [ProfileController::class, 'update']);  
    Route::patch('/{id}', [ProfileController::class, 'update']); 
    Route::delete('/{id}', [ProfileController::class, 'destroy']); 
});

Route::get('/following', [FollowingController::class, 'index']); 
Route::get('/follower/{organizer}', [FollowingController::class, 'showFollower']); //menampilkan detail pengikut suatu penyelenggara
Route::get('/following/{volunteer}', [FollowingController::class, 'show']); //menampilkan detail penyelenggara yang diikuti oleh volunteer
Route::post('/following', [FollowingController::class, 'store']); //memfollow penyelenggara
Route::patch('/following/{organizer}/notifications', [FollowingController::class, 'update']); //update notifikasi
Route::delete('/following/{organizer}', [FollowingController::class, 'destroy']); //batal follow

// --- USER (umum)
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// --- ADMIN
Route::get('/admins', [AdminController::class, 'index']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::post('/admins', [AdminController::class, 'store']);
Route::put('/admins/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

// --- ORGANIZER
Route::get('/organizers', [OrganizerController::class, 'index']);
Route::get('/organizers/{id}', [OrganizerController::class, 'show']);
Route::post('/organizers', [OrganizerController::class, 'store']);
Route::put('/organizers/{id}', [OrganizerController::class, 'update']);
Route::delete('/organizers/{id}', [OrganizerController::class, 'destroy']);

// --- VOLUNTEER
Route::get('/volunteers', [VolunteerController::class, 'index']);
Route::get('/volunteers/{id}', [VolunteerController::class, 'show']);
Route::post('/volunteers', [VolunteerController::class, 'store']);
Route::put('/volunteers/{id}', [VolunteerController::class, 'update']);
Route::delete('/volunteers/{id}', [VolunteerController::class, 'destroy']);