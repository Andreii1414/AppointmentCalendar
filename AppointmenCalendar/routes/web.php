<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'registerUser'])->name('registerUser');
Route::get('/register', function () {
    return view('register');
});

Route::get('/success', function () {
    return view('success');
})->name('success');