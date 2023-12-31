<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'registerUser'])->name('registerUser');
Route::get('/register', function () {
    return view('register');
});

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::post('/login', [LoginController::class, 'loginUser'])->name('loginUser');
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::middleware('checksessionexpiration')->group(function () {    
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/verify-form', function () {
        return view('verify');
    })->name('verify-form');

    Route::get('/code', function () {
        return view('code');
    })->name('code');
});

Route::get('/get-appointments', [AppointmentController::class, 'getAppointments'])->name('getAppointments');

Route::post('/create-appointment', [AppointmentController::class, 'createAppointment'])->name('createAppointment');

Route::get('/get-your-appointments', [AppointmentController::class, 'getYourAppointments'])->name('getYourAppointments');

Route::put('/remove-appointment', [AppointmentController::class, 'removeAppointment'])->name('removeAppointment');

Route::delete('/delete-user', [AdminController::class, 'deleteUser'])->name('deleteUser');

Route::get('/get-all-appointments', [AdminController::class, 'getAllAppointments'])->name('getAllAppointments');

Route::get('/verify', [VerifyController::class, 'sendToken'])->name('verify');

Route::post('/verify-code', [VerifyController::class, 'verifyCode'])->name('verifyCode');

Route::delete('/delete-past-appointments', [AdminController::class, 'deletePastAppointments'])->name('deletePastAppointments');
