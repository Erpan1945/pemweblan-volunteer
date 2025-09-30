<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ActivityController;



//Publikasi Kegiatan (Activities)

// 1. Get All Activities (Mendapatkan semua kegiatan)
// Method: GET, Endpoint: /api/activities
Route::get('activities', [ActivityController::class, 'index']);
// 2. Create New Activity (Membuat kegiatan baru)
// Method: POST, Endpoint: /api/activities
Route::post('activities', [ActivityController::class, 'store']);
// 3. Get Single Activity (Mendapatkan detail satu kegiatan)
// Method: GET, Endpoint: /api/activities/{id}
Route::get('activities/{activity}', [ActivityController::class, 'show']);
// 4. Update Activity (PUT - Memperbarui seluruh data)
// Method: PUT, Endpoint: /api/activities/{id}
Route::put('activities/{activity}', [ActivityController::class, 'update']);
// 5. Update Activity (PATCH - Memperbarui sebagian data)
// Method: PATCH, Endpoint: /api/activities/{id}
Route::patch('activities/{activity}', [ActivityController::class, 'patch']);
// 6. Delete Activity (Menghapus kegiatan)
// Method: DELETE, Endpoint: /api/activities/{id}
Route::delete('activities/{activity}', [ActivityController::class, 'destroy']);
