<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Inertia\AlwaysProp;
use Inertia\DeferProp;
use Inertia\OptionalProp;
use Inertia\Response as InertiaResponse;

uses(RefreshDatabase::class);

describe('authUser', function () {
    it('returns the authenticated user when user is logged in', function () {
        $user = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $this->actingAs($user);

        expect(authUser())
            ->toBeInstanceOf(User::class)
            ->id->toBe($user->id)
            ->name->toBe('John Doe')
            ->email->toBe('john@example.com');
    });

    it('throws AuthenticationException when no user is authenticated', function () {
        Auth::logout();

        expect(fn () => authUser())
            ->toThrow(AuthenticationException::class);
    });

    it('throws AuthenticationException when user is null', function () {
        Auth::shouldReceive('user')->once()->andReturn(null);

        expect(fn () => authUser())
            ->toThrow(AuthenticationException::class);
    });
});

describe('Inertia', function () {
    describe('vue', function () {
        it('creates an Inertia response with component name only', function () {
            $response = vue('Home');

            expect($response)
                ->toBeInstanceOf(InertiaResponse::class);
        });

        it('creates an Inertia response with props', function () {
            $props = ['user' => 'John', 'count' => 5];
            $response = vue('Home', $props);

            expect($response)
                ->toBeInstanceOf(InertiaResponse::class)
                ->and((new ReflectionClass($response))->getProperty('props')->getValue($response))
                ->toHaveKey('user', 'John')
                ->toHaveKey('count', 5);

        });

        it('creates an Inertia response with meta props as array', function () {
            $props = ['data' => 'test'];
            $metaProps = ['title' => 'Test Page', 'description' => 'A test page'];

            $response = vue('TestPage', $props, $metaProps);

            $props = (new ReflectionClass($response))->getProperty('props')->getValue($response);
            expect($props)
                ->toHaveKey('meta')
                ->and($props['meta'])
                ->toBe(['title' => 'Test Page', 'description' => 'A test page']);
        });
    });

    describe('optionalProp', function () {
        it('creates an OptionalProp instance', function () {
            $callback = fn () => 'optional data';
            expect(optionalProp($callback))->toBeInstanceOf(OptionalProp::class);
        });
    });

    describe('deferProp', function () {
        it('creates a DeferProp instance with default group', function () {
            $callback = fn () => 'deferred data';
            expect(deferProp($callback))->toBeInstanceOf(DeferProp::class);
        });
    });

    describe('alwaysProp', function () {
        it('creates an AlwaysProp instance', function () {
            $data = 'always included';
            expect(alwaysProp($data))->toBeInstanceOf(AlwaysProp::class);
        });
    });
});
