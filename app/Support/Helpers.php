<?php

declare(strict_types=1);

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
