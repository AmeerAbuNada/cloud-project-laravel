<?php

use App\Http\Controllers\Auth\AccountSettingsController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientRelationsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegistrationController;
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

Route::middleware('completeRegistration')->group(function () {
    Route::redirect('/', '/login');

    //Authenticated Routes
    Route::middleware('auth')->group(function () {

        Route::withoutMiddleware('completeRegistration')->get('/under-review', [RegistrationController::class, 'underReview']);

        //Account Settings
        Route::view('/', 'crm.parent')->name('crm.home');
        Route::prefix('/account-settings')->controller(AccountSettingsController::class)->group(function () {
            Route::withoutMiddleware('completeRegistration')->get('/profile', 'showProfile')->name('account.profile');
            Route::withoutMiddleware('completeRegistration')->put('/profile/complete', 'completeRegistration')->name('account.complete-registration');
            Route::get('/info', 'showGeneralInfo')->name('account.general-info');
            Route::put('/info', 'updateGeneralInfo')->name('account.update-general-info');
            Route::get('/change-password', 'showChangePassword')->name('account.change-password');
            Route::put('/change-password', 'changePassword')->name('account.update-change-password');
            Route::get('/accomplishments', 'accomplishments')->name('account.accomplishments');
            Route::put('/accomplishments', 'updateAccomplishments')->name('account.update-accomplishments');
        });

        Route::middleware('role:manager')->group(function () {
            Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
            Route::post('/registrations/{user}/accept', [RegistrationController::class, 'accept'])->name('registrations.accept');
            Route::post('/registrations/{user}/deny', [RegistrationController::class, 'deny'])->name('registrations.deny');
            Route::get('/users/{user}', [RegistrationController::class, 'user'])->name('users.show');

            Route::resource('managers', ManagerController::class);
            Route::resource('courses', CourseController::class);
        });


        Route::middleware('role:trainee')->group(function () {
            Route::get('/available-courses', [MainController::class, 'availableCourses'])->name('availableCourses');
            Route::post('/available-courses/{course}/apply', [MainController::class, 'applyForCourse']);
            Route::post('/available-courses/{course}/remove', [MainController::class, 'removeCourse']);
            Route::post('/attend/{course}', [MainController::class, 'addAttendance']);
            Route::post('/meeting/{course}', [MainController::class, 'requestMeeting']);
        });
        Route::middleware('role:advisor,trainee')->group(function () {
            Route::get('/available-courses/{course}', [MainController::class, 'showCourse'])->name('showCourse');
            Route::get('/myMeetings', [MainController::class, 'myMeetings'])->name('myMeetings');
            Route::get('/myCourses', [MainController::class, 'myCourses'])->name('myCourses');
            Route::delete('/myMeetings/{meeting}', [MainController::class, 'deleteMeeting'])->name('deleteMeeting');
        });
        Route::middleware('role:advisor')->group(function () {
            Route::put('/myMeetings/{meeting}', [MainController::class, 'acceptMeeting'])->name('acceptMeeting');
            Route::post('/sendEmail/{user}', [MainController::class, 'sendEmail']);
        });
    });

    //Logout Route
    Route::withoutMiddleware('completeRegistration')->get('/logout', [LoginController::class, 'logout'])->name('logout');

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
});
