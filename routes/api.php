<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum', 'single.device'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/check-session', [UserController::class, 'checkSession']);
    Route::post('/get_users_list', [UserController::class, 'get_users_list']);
});
