<?php

use App\Http\Controllers\Auth\AccountSettingsController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientRelationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\User\FileController as UserFileController;
use App\Http\Controllers\User\ProjectController as UserProjectController;
use App\Http\Controllers\User\TaskController as UserTaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRelationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login');

//Authenticated Routes
Route::middleware('auth')->group(function () {
    //Account Settings
    Route::view('/', 'crm.parent')->name('crm.home');
    Route::prefix('/account-settings')->controller(AccountSettingsController::class)->group(function () {
        Route::get('/profile', 'showProfile')->name('account.profile');
        Route::get('/info', 'showGeneralInfo')->name('account.general-info');
        Route::put('/info', 'updateGeneralInfo')->name('account.update-general-info');
        Route::get('/change-password', 'showChangePassword')->name('account.change-password');
        Route::put('/change-password', 'changePassword')->name('account.update-change-password');
    });
});

//Logout Route
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Guest Routes
Route::middleware('guest')->group(function () {
    //Login Routes
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.post');

    //Reset Password Routes
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showForgotPassword')->name('password.request');
        Route::post('/forgot-password', 'forgotPassword')->name('password.email');
        Route::get('/reset-password/{token}', 'showResetPassword')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });
});