<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\VolunteerController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- ACTIVITIES ---
// Rute spesifik (yang memiliki kata-kata unik) harus diletakkan di ATAS rute umum.
Route::prefix('activities')->controller(ActivityController::class)->group(function () {
    Route::get('/mine', 'mine')->name('activities.mine');
    Route::patch('/{activity}/schedule', 'schedule')->name('activities.schedule');
    Route::patch('/{activity}/approve', 'approve')->name('activities.approve'); // <-- INI RUTE ANDA
    Route::patch('/{activity}/reject', 'reject')->name('activities.reject');
});

// Rute umum (CRUD standar) yang dibuat otomatis
Route::apiResource('activities', ActivityController::class);
Route::apiResource('organizers', OrganizerController::class);
Route::apiResource('volunteers', VolunteerController::class);

Route::get('/user', [UserController::class, 'show']);