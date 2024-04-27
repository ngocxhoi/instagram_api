<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'update']);
    Route::post('/update-user-image', [UserController::class, 'updateUserImage']);
    Route::patch('/update-user', [UserController::class, 'update']);

    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/post', [PostController::class, 'store']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    Route::get('/comments-post/{id}', [CommentController::class, 'updatePostComment']);
    Route::post('/comment', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    Route::get('/likes-post/{id}', [LikeController::class, 'updatePostLike']);
    Route::post('/like', [LikeController::class, 'store']);
    Route::delete('/likes/{id}', [LikeController::class, 'destroy']);
});

Route::get('/home', [HomeController::class, 'index']);

Route::get('/get-random-users', [ProfileController::class, 'getRandomUsers']);

Route::get('/profiles/{id}', [ProfileController::class, 'show']);
