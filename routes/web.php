<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Home'))->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('/dashboard')->as('dashboard.')
    ->group(function () {
        Route::get('/', fn () => inertia('dashboard/Index'))->name('index');
    });

Route::middleware('auth')
    ->prefix('/account')->as('account.')
    ->group(function () {
        Route::middleware('verified')->group(function () {
            Route::get('/', fn () => inertia('account/Index'))->name('index');
        });

        require __DIR__ . '/settings.php';
    });

require __DIR__ . '/auth.php';
