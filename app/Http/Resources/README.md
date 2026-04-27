# HTTP Resources

This directory contains the application's shared resource layer for both API responses and Inertia props.

## Goals

- Keep resource classes small and predictable.
- Reuse the same serializer for API and Inertia.
- Prefer explicit field definitions over raw `$model->toArray()` dumps.

## Base Classes

- `AppResource` is the base class for single resources.
- `AppResourceCollection` is the base collection returned automatically from `AppResource::collection()`.
- `Concerns/FlexibleJsonResource` contains the shared field helpers used by `AppResource`.

## Common Patterns

### Basic resource

```php
<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

final class UserResource extends AppResource
{
    /**
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->id(),
            $this->attribute('name'),
            $this->attribute('email'),
            ...$this->timestamps(),
        ];
    }
}
```

### Send a single resource to Inertia

```php
return vue('users/Show', [
    'user' => UserResource::make($user)->toInertia(),
]);
```

### Send a paginated resource collection to Inertia

```php
return vue('users/Index', [
    'users' => UserResource::collection(User::query()->latest()->paginate())->toInertia(),
]);
```

The paginated payload shape is:

```php
[
    'data' => [...],
    'links' => [
        'first' => '...',
        'last' => '...',
        'prev' => null,
        'next' => '...',
    ],
    'meta' => [
        'current_page' => 1,
        'from' => 1,
        'last_page' => 4,
        'path' => 'https://app.test/users',
        'per_page' => 15,
        'to' => 15,
        'total' => 50,
    ],
]
```

### Relations

Use `relation()` when the relation should only be serialized if it was eager loaded:

```php
$this->relation('posts', resolver: fn ($posts) => PostResource::collection($posts)->resolve())
```

That keeps resources safe from accidental lazy loading.

### Key customization

`attribute()` and `optionalAttribute()` support `alias`, `prefix`, and `suffix`:

```php
$this->attribute('name', alias: 'display', prefix: 'user_', suffix: '_label')
```

Output key: `user_display_label`

### Transform values

Use the `resolver` closure whenever the output shape differs from the stored value:

```php
$this->attribute('status', resolver: fn (Status $status): string => $status->value)
```

### Timestamps

- `...$this->timestamps()` expands to `created_at` and `updated_at`
- `...$this->softDeleteTimestamps()` expands to `created_at`, `updated_at`, and `deleted_at`

## Conventions

- Extend `AppResource`, not `JsonResource` directly.
- Keep `toArray()` focused on serialization only.
- Use `relation()` for loaded relations instead of touching relations directly.
- Use `toInertia()` when passing resources into `vue()` props.
- Generate resources with `php artisan make:resource UserResource` — uses `stubs/resource.stub`
- Generate collections with `php artisan make:resource UserCollection --collection` — uses `stubs/resource-collection.stub`
