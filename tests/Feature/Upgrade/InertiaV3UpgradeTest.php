<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('inertia v3 config keeps the custom page lookup path', function () {
    expect(config('inertia.pages.paths'))
        ->toBe([resource_path('views')])
        ->and(config('inertia.pages.extensions'))
        ->toContain('vue')
        ->and(config('inertia.testing.ensure_pages_exist'))
        ->toBeTrue();
});

test('the root inertia blade template uses the v3 data inertia title attribute', function () {
    get('/login')
        ->assertSuccessful()
        ->assertSee('<title data-inertia>', false)
        ->assertDontSee('<title inertia>', false);
});
