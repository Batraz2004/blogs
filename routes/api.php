<?php

use App\Http\Controllers\LoginController;
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
