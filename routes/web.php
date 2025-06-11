<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'throttle:web'])->get('/', function () {
    logger()->channel('telegram')->info('Открыта страница' . " " . request()->url()); // логер из роутов вынесен в кернел пхп
    return view('welcome');
});

Route::middleware(['web', 'throttle:web'])->group(function () {
    Route::get('/test-page-1', function () {
        logger()->channel('telegram')->info('Открыта страница' . " " . request()->url());
        return 'test-page-1';
    });

    Route::get('/test-page-2', function () {
        logger()->channel('telegram')->info('Открыта страница' . " " . request()->url());
        return 'test-page-2';
    });
});


