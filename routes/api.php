<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "v1"], function (){
    Route::get('/token', [TokenController::class, "token"])->name("api.token");
    Route::get('/users', [UserController::class, "users"])->name("api.users");
    Route::get('/positions', [PositionController::class, "positions"])->name("api.positions");
    Route::get('/users/{id}', [UserController::class, "usersShow"])->name("api.users.show");
    Route::post('/users', [UserController::class, "usersStore"])->name("api.users.store");
});
