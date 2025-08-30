<?php

declare(strict_types=1);

use App\DTOs\PageMeta;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

Route::middleware('auth')->group(function () {
    Route::redirect('/settings/', '/settings/profile');

    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings/password', [PasswordController::class, 'edit'])->name('password.edit');

    Route::put('/settings/password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    Route::get('/settings/appearance', fn (): Response => vue('settings/Appearance', metaProps: new PageMeta(title: 'Appearance settings')))
        ->name('appearance');
});
