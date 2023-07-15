<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
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
});
