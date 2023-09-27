<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimekeeperController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EmailVerificationController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [TimekeeperController::class, 'index']);

    Route::get('/email/verify', [EmailVerificationController::class, 'index'])->name('verification.notice');

    Route::middleware('signed')->group(function (){
        Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verification'])->name('verification.verify');
    });

    Route::middleware('throttle:6,1')->group(function (){
        Route::post('/email/verification-notification', [EmailVerificationController::class, 'notification'])->name('verification.send');
    });

    Route::middleware('verified')->group(function (){
        Route::post('/', [TimekeeperController::class, 'store']);
        Route::get('/attendance/{date?}',[AttendanceController::class, 'attendance']);
        Route::get('/users',[UsersController::class, 'users']);
        Route::get('/schedule/{user_id?}',[UsersController::class, 'schedule']);
    });
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
