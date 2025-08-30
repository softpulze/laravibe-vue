<?php

declare(strict_types=1);

use App\Data\PageMeta;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

Route::get('/', fn (): Response => vue('Home', metaProps: new PageMeta(title: 'Home')))->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('/administration')->as('administration.')
    ->group(function () {
        Route::redirect('/', 'administration/dashboard');
        Route::get('/dashboard', fn (): Response => vue('administration/Dashboard', metaProps: new PageMeta(title: 'Dashboard')))
            ->name('dashboard');
    });

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::redirect('/dashboard', '/settings/profile')->name('dashboard');
    });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
