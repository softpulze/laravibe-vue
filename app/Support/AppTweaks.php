<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

final class AppTweaks
{
    public static function default(): void
    {
        self::dbCommands();
        self::urls();
        self::date();
        self::models();
        self::resources();
        self::vite();
    }

    public static function models(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
    }

    public static function resources(): void
    {
        JsonResource::withoutWrapping();
    }

    public static function dbCommands(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());
    }

    public static function date(): void
    {
        // CarbonImmutable as default
        Date::use(Carbon::class);
    }

    public static function vite(): void
    {
        Vite::prefetch(concurrency: 3);
    }

    public static function urls(): void
    {
        URL::forceScheme('https');
    }
}
