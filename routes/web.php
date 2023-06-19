<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SampahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/sampah', [SampahController::class, 'index']);
// Route::get('/sampah/{id}', [SampahController::class, 'show']);
// Route::post('/sampah/store', [SampahController::class, 'store']);
// Route::post('/sampah/update/{id}', [SampahController::class, 'update']);
// Route::delete('/sampah/{id}', [SampahController::class, 'destroy']);
// Route::get('/sampah/trash/all', [SampahController::class, 'trash']);
// Route::post('/sampah/restore/{id}', [SampahController::class, 'restore']);
// Route::delete('/sampah/forceDelete/{id}', [SampahController::class, 'forceDelete']);