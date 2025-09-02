<?php

declare(strict_types=1);

if (! function_exists('authUser')) {
    /**
     * Get the authenticated user or throw an exception if not authenticated.
     */
    function authUser(): App\Models\User
    {
        $authUser = Illuminate\Support\Facades\Auth::user();
        throw_if(is_null($authUser), Illuminate\Auth\AuthenticationException::class);

        return $authUser;
    }
}

// Inertia helpers start
if (! function_exists('vue')) {
    /**
     * @param  array<string, mixed>  $props
     * @param  array<string, mixed>|Illuminate\Contracts\Support\Arrayable<string, mixed>  $metaProps
     */
    function vue(string $name, array $props = [], array|Illuminate\Contracts\Support\Arrayable $metaProps = []): Inertia\Response
    {
        if ($metaProps instanceof Illuminate\Contracts\Support\Arrayable) {
            $metaProps = $metaProps->toArray();
        }

        return inertia($name, [...$props, 'meta' => $metaProps]);
    }
}

if (! function_exists('optionalProp')) {
    function optionalProp(callable $callback): Inertia\OptionalProp
    {
        return Inertia\Inertia::optional($callback);
    }
}

if (! function_exists('deferProp')) {
    function deferProp(callable $callback, string $group = 'default'): Inertia\DeferProp
    {
        return Inertia\Inertia::defer($callback, $group);
    }
}

if (! function_exists('alwaysProp')) {
    function alwaysProp(mixed $callback): Inertia\AlwaysProp
    {
        return Inertia\Inertia::always($callback);
    }
}
// Inertia helpers end

// Flash helpers start
if (! function_exists('flashError')) {
    function flashError(string $message, App\DTOs\FlashAction ...$actions): void
    {
        App\DTOs\Flash::error($message, ...$actions);
    }
}

if (! function_exists('flashSuccess')) {
    function flashSuccess(string $message, App\DTOs\FlashAction ...$actions): void
    {
        App\DTOs\Flash::success($message, ...$actions);
    }
}

if (! function_exists('flashWarning')) {
    function flashWarning(string $message, App\DTOs\FlashAction ...$actions): void
    {
        App\DTOs\Flash::warning($message, ...$actions);
    }
}

if (! function_exists('flashInfo')) {
    function flashInfo(string $message, App\DTOs\FlashAction ...$actions): void
    {
        App\DTOs\Flash::info($message, ...$actions);
    }
}

if (! function_exists('flashActionCopy')) {
    function flashActionCopy(string $payloadToCopy, ?string $label = null): App\DTOs\FlashAction
    {
        return App\DTOs\FlashAction::copy($payloadToCopy, $label);
    }
}

if (! function_exists('flashActionRedirect')) {
    function flashActionRedirect(string $redirectURL, ?string $label = null): App\DTOs\FlashAction
    {
        return App\DTOs\FlashAction::redirect($redirectURL, $label);
    }
}
// Flash helpers end
