<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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
// users
Route::get('/users', [UserController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // user
    Route::get('/loggeduser', [UserController::class, 'loggedUser']);
    Route::get('/user/{id}', [UserController::class, 'detail']);
    Route::post('/user/{id}/update', [UserController::class, 'update']);
    Route::post('/user/{id}/picture', [UserController::class, 'updatePicture']);

    // post
    Route::post('/post', [PostController::class, 'store']);
    Route::get('/posts', [PostController::class, 'show']);
    Route::get('/mypost', [PostController::class, 'myPost']);
    Route::get('/post/{id}', [PostController::class, 'postDetail']);
    Route::post('/post/{id}/update', [PostController::class, 'update']);
    Route::delete('/post/{id}/delete', [PostController::class, 'destroy']);
    Route::post('/addlike/{id}', [PostController::class, 'addlike']);

    // comment
    Route::post('/comment/{postId}', [CommentController::class, 'store']);
    Route::get('/comments/{postId}', [CommentController::class, 'show']);
    Route::get('/comment/{id}', [CommentController::class, 'commentDetail']);
    Route::post('/comment/{Id}/update', [CommentController::class, 'update']);
    Route::delete('/comment/{Id}/delete', [CommentController::class, 'destroy']);
    
});


