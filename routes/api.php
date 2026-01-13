<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return UserResource::make($request->user());
})->middleware('auth:sanctum');

Route::post('registration', [RegistrationController::class, 'createUser']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::prefix('post')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [PostController::class, 'create']);
    Route::get('/', [PostController::class, 'list']);
    Route::prefix('{postId}')->group(function () {
        Route::post('/', [PostController::class, 'update']);
        Route::get('/', [PostController::class, 'get']);
        Route::delete('/', [PostController::class, 'delete']);
    });
});

Route::prefix('comment')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [CommentController::class, 'create']);
    Route::get('list/user', [CommentController::class, 'listByUser']);
    Route::get('post/{postId}', [CommentController::class, 'listByPost']);
    Route::prefix('{commentId}')->group(function () {
        Route::post('/', [CommentController::class, 'update']);
        Route::delete('/', [CommentController::class, 'delete']);
    });
});
