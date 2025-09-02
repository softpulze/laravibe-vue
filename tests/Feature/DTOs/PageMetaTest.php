<?php

declare(strict_types=1);

use App\DTOs\BreadCrumb;
use App\DTOs\PageMeta;
use Illuminate\Support\Collection;

it('serializes with only provided fields and filters nulls', function (): void {
    $meta = new PageMeta(heading: 'Users', title: 'Users - Admin');

    expect($meta->toArray())->toBe([
        'heading' => 'Users',
        'title' => 'Users - Admin',
    ]);

    $json = $meta->toJson(JSON_UNESCAPED_SLASHES);
    expect($json)->toBeJson()
        ->and(json_decode($json, true))->toBe([
            'heading' => 'Users',
            'title' => 'Users - Admin',
        ]);
});

it('serializes breadcrumbs collection of BreadCrumb DTOs', function (): void {
    $breadcrumbs = new Collection([
        new BreadCrumb('Home', '/'),
        new BreadCrumb('Users', '/users'),
    ]);

    $meta = new PageMeta(
        heading: 'Users',
        subheading: 'Manage accounts',
        title: 'Users - Admin',
        breadcrumbs: $breadcrumbs,
    );

    expect($meta->toArray())->toBe([
        'heading' => 'Users',
        'subheading' => 'Manage accounts',
        'title' => 'Users - Admin',
        'breadcrumbs' => [
            ['label' => 'Home', 'href' => '/'],
            ['label' => 'Users', 'href' => '/users'],
        ],
    ]);
});
