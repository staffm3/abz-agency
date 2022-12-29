<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [MainController::class, "home"])->name("home");
Route::get("/users", [MainController::class, "users"])->name("users");
Route::get("/user/create", [MainController::class, "userCreate"])->name("user.create");
Route::post("/user/store", [UserController::class, "userStore"])->name("user.store");
Route::get("/positions", [MainController::class, "positions"])->name("positions");
