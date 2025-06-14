<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', HomeController::class)->name('home');


Route::middleware(['web', 'throttle:web'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // роут отображения
        Route::get('/login', 'login')->name('login');
        // роут обработки
        Route::post('/login', 'signin')->name('signin');

        // роут отображения
        Route::get('/register', 'register')->name('register');
        // роут обработки
        Route::post('/register', 'registeruser')->name('registeruser');

        Route::delete('/logout', 'logout')
            ->middleware('auth')
            ->name('logout');


        Route::get('/forgot-password', 'forgot')
            ->middleware('guest')
            ->name('password.request');

        Route::post('/forgot-password', 'forgotPassword')
            ->middleware('guest')
            ->name('password.email');


        Route::get('/reset-password/{token}', 'reset')
            ->middleware('guest')
            ->name('password.reset');


        Route::post('/reset-password', 'resetPassword')
            ->middleware('guest')
            ->name('password.update');


        Route::get('/auth/socialite/github', 'github')->name('social.github');

        Route::get('/auth/socialite/github/callback', 'githubCallback')
            ->name('socialite.github.callback');
    });
});
