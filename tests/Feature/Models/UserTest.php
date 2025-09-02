<?php

declare(strict_types=1);

use App\Models\User;
use App\Support\CarbonImmutable;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'name', 'email',
        'email_verified_at',
        'created_at', 'updated_at',
    ]);
});

test('casts', function () {
    $user = User::factory()->create()->fresh();

    expect($user)
        ->id->toBeInt()
        ->name->toBeString()
        ->email->toBeString()
        ->email_verified_at->toBeInstanceOf(CarbonImmutable::class)
        ->created_at->toBeInstanceOf(CarbonImmutable::class)
        ->updated_at->toBeInstanceOf(CarbonImmutable::class);
});
