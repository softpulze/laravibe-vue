<?php

declare(strict_types=1);

namespace App\Toast;

use Illuminate\Support\ServiceProvider;

final class ToastServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Toast::class, fn () => new Toast());
    }
}
