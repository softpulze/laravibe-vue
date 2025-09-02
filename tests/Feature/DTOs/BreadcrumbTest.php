<?php

declare(strict_types=1);

use App\DTOs\BreadCrumb;

it('creates breadcrumb with label and optional href', function (): void {
    $b1 = new BreadCrumb(label: 'Dashboard');
    $b2 = new BreadCrumb(label: 'Users', href: '/users');

    expect($b1)
        ->label->toBe('Dashboard')
        ->and($b1->href)->toBeNull()
        ->and($b2)
        ->label->toBe('Users')
        ->and($b2->href)->toBe('/users');

});

it('serializes to array correctly', function (): void {
    $dto = new BreadCrumb(label: 'Settings', href: '/settings');

    expect($dto->toArray())
        ->toBe([
            'label' => 'Settings',
            'href' => '/settings',
        ]);
});

it('serializes to json correctly and is valid json', function (): void {
    $dto = new BreadCrumb(label: 'Profile', href: '/profile');

    $json = $dto->toJson(JSON_UNESCAPED_SLASHES);

    expect($json)->toBeJson()
        ->and(json_decode($json, true))
        ->toBe([
            'label' => 'Profile',
            'href' => '/profile',
        ]);
});
