<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\AuthenticateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[AuthenticateController::class,'login']);

Route::get('/posts',[PostController::class,'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/logout',[AuthenticateController::class,'logout']);

    Route::get('/posts/{post:id}',[PostController::class,'show']);
    // Route::get('/posts',[PostController::class,'index']);
});
