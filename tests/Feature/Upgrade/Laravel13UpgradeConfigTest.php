<?php

declare(strict_types=1);

use Illuminate\Support\Str;

test('laravel 13 upgrade keeps the existing cache and session naming conventions', function () {
    expect(config('cache.prefix'))
        ->toBe(Str::slug((string) env('APP_NAME', 'laravel'), '_') . '_cache_')
        ->and(config('database.redis.options.prefix'))
        ->toBe(Str::slug((string) env('APP_NAME', 'laravel'), '_') . '_database_')
        ->and(config('session.cookie'))
        ->toBe(Str::slug((string) env('APP_NAME', 'laravel'), '_') . '_session');
});

test('laravel 13 cache serialization hardening is enabled', function () {
    expect(config('cache')['serializable_classes'] ?? null)->toBeFalse();
});
