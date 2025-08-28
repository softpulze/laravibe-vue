<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Home'))->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('/administration')->as('administration.')
    ->group(function () {
        Route::redirect('/', 'administration/dashboard');
        Route::get('/dashboard', fn () => inertia('administration/Dashboard'))->name('dashboard');
    });

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::redirect('/dashboard', '/settings/profile')->name('dashboard');
    });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
