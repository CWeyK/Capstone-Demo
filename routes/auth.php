<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('login', 'auth.login')
    ->name('login');

Volt::route('forgot-password', 'auth.forgot-password')
    ->name('password.request');

Volt::route('reset-password/{token}', 'auth.reset-password')
    ->name('password.reset');

Volt::route('register/ref={code}', 'auth.register')
    ->name('register');

//Route::middleware('auth:admin')->group(function () {
//    Volt::route('verify-email', 'pages.auth.verify-email')
//        ->name('verification.notice');

//    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
//        ->middleware(['signed', 'throttle:6,1'])
//        ->name('verification.verify');

//    Volt::route('confirm-password', 'pages.auth.confirm-password')
//        ->name('password.confirm');
//});
