<?php

declare(strict_types=1);

namespace App\Toast;

use Illuminate\Support\ServiceProvider;
use Override;

final class ToastServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->singleton(Toast::class, fn (): Toast => new Toast());
    }
}
