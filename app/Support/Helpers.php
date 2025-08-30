<?php

declare(strict_types=1);

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

if (! function_exists('vue')) {
    function vue(string $name, array $props = [], array|Arrayable $metaProps = []): RedirectResponse|Response
    {
        if ($metaProps instanceof Arrayable) {
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
