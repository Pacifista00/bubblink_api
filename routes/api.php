<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// auth register & login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // users
    Route::get('/users', [AuthController::class, 'show']);

    // user
    Route::get('/user/{id}', [AuthController::class, 'detail']);
    Route::put('/user/{id}', [AuthController::class, 'update']);

    // post
    Route::post('/post', [PostController::class, 'store']);
    Route::get('/posts', [PostController::class, 'postDetail']);
    Route::get('/post/{id}', [PostController::class, 'show']);
    Route::put('/post/{id}/update', [PostController::class, 'update']);
    Route::delete('/post/{id}/delete', [PostController::class, 'destroy']);
    
});


