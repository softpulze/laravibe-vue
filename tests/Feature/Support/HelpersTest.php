<?php

declare(strict_types=1);

use App\DTOs\Flash;
use App\DTOs\FlashAction;
use App\Enums\FlashActionType;
use App\Enums\FlashType;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

describe('Flash', function () {
    beforeEach(fn () => Session::flush());

    describe('flashActionCopy', function () {
        it('creates a flash action with type of copy, payload and label', function () {
            expect(flashActionCopy('text-to-copy', 'Copy Text'))
                ->toBeInstanceOf(FlashAction::class)
                ->type->toBe(FlashActionType::COPY)
                ->payload->toBe('text-to-copy')
                ->label->toBe('Copy Text');
        });

        it('creates a flash action with type of copy, payload only', function () {
            expect(flashActionCopy('copy-this'))
                ->type->toBe(FlashActionType::COPY)
                ->payload->toBe('copy-this')
                ->label->toBeNull();
        });
    });

    describe('flashActionRedirect', function () {
        it('creates a flash action with type of redirect, URL and label', function () {
            expect(flashActionRedirect('https://example.com', 'Example Label'))
                ->toBeInstanceOf(FlashAction::class)
                ->type->toBe(FlashActionType::REDIRECT)
                ->payload->toBe('https://example.com')
                ->label->toBe('Example Label');
        });

        it('creates a redirect action with URL only', function () {
            expect(flashActionRedirect('https://example.com'))
                ->type->toBe(FlashActionType::REDIRECT)
                ->payload->toBe('https://example.com')
                ->label->toBeNull();
        });
    });

    describe('flashError', function () {
        it('creates an error flash message', function () {
            flashError('An error occurred');

            $flash = Flash::pull();
            expect($flash)
                ->toBeArray()
                ->toHaveCount(1)
                ->and($flash[0])
                ->toHaveKey('type', FlashType::ERROR->value)
                ->toHaveKey('message', 'An error occurred');
        });

        it('creates an error flash message with actions', function () {
            flashError('Something went wrong', flashActionCopy('error-123', 'Copy Error ID'), flashActionRedirect('/support', 'Get Help'));

            $flash = Flash::pull();
            expect($flash[0])->toHaveKey('actions')
                ->and($flash[0]['actions'])->toHaveCount(2)
                ->and($flash[0]['actions'][0])
                ->toHaveKey('type', FlashActionType::COPY->value)
                ->toHaveKey('payload', 'error-123')
                ->toHaveKey('label', 'Copy Error ID')
                ->and($flash[0]['actions'][1])
                ->toHaveKey('type', FlashActionType::REDIRECT->value)
                ->toHaveKey('payload', '/support')
                ->toHaveKey('label', 'Get Help');
        });
    });

    describe('flashSuccess', function () {
        it('creates a success flash message', function () {
            flashSuccess('Operation completed successfully');

            $flash = Flash::pull();
            expect($flash)
                ->toBeArray()
                ->toHaveCount(1)
                ->and($flash[0])
                ->toHaveKey('type', FlashType::SUCCESS->value)
                ->toHaveKey('message', 'Operation completed successfully');
        });
    });

    describe('flashWarning', function () {
        it('creates a warning flash message', function () {
            flashWarning('Please verify your email');

            expect(Flash::pull()[0])
                ->toHaveKey('type', FlashType::WARNING->value)
                ->toHaveKey('message', 'Please verify your email');
        });
    });

    describe('flashInfo', function () {
        it('creates an info flash message', function () {
            flashInfo('New features available');

            expect(Flash::pull()[0])
                ->toHaveKey('type', FlashType::INFO->value)
                ->toHaveKey('message', 'New features available');
        });
    });
});
