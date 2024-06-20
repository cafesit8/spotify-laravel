<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfilePhotoController;
use App\Http\Controllers\SongDetailsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::resource('users', UserController::class);
Route::resource('profile_photo', ProfilePhotoController::class);
Route::resource('song_details', SongDetailsController::class);
Route::get('/songs/search/{title}', [SongDetailsController::class, 'search']);
Route::get('/songs/categories/{category}', [SongDetailsController::class, 'getByCategory']);
Route::resource('categories', CategoryController::class);

// Login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/user', [AuthController::class, 'user']);
});
