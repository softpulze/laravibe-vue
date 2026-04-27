# DTO Guide

## Purpose

DTOs provide a small and typed boundary between HTTP payloads, actions, services, and persistence. They keep transformation logic in one place while preserving immutable, predictable data contracts.

## Benefits

- Immutable payloads via final readonly classes.
- Safer hydration with clear error messages for missing or invalid fields.
- Fast metadata caching for repeated hydration.
- Consistent serialization for APIs, JSON responses, and Eloquent writes.

## Placement and Shape

- Store DTOs in app/DTOs or app/DTOs/{Domain}.
- Use singular names with DTO suffix, for example UserProfileDTO.
- Every DTO must be final readonly and use App\DTOs\Concerns\AsDTO.
- Keep DTOs focused on data transfer; avoid business logic in DTOs.

## Manual DTO Example

```php
<?php

declare(strict_types=1);

namespace App\DTOs\Account;

use App\DTOs\Concerns\AsDTO;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class UpdateProfileDTO implements Arrayable, Jsonable
{
	use AsDTO;

	public function __construct(
		public string $name,
		public ?string $bio = null,
	) {
	}
}
```

## Generate via Artisan

Create a DTO with:

```bash
php artisan make:dto Account/UpdateProfileDTO
```

The command uses stubs/dto.stub and creates the class under app/DTOs.

## Hydration and Serialization

```php
$dto = UpdateProfileDTO::from([
	'name' => 'Example Name',
	'bio' => 'I can do something awesome.',
]);

$dto = UpdateProfileDTO::fromRequest($request);

$payload = $dto->toArray();
$json = $dto->toJson();
$attributes = $dto->toEloquent();
```

## Immutably Updating a DTO

```php
$updated = $dto->with([
	'bio' => 'Updated profile bio',
]);
```

## Eloquent Usage

Use toEloquent when passing attributes to models:

```php
UserProfile::create($dto->toEloquent());
```

If you need to merge extras such as derived keys, forEloquent remains available:

```php
UserProfile::create($dto->forEloquent([
	'source' => 'import',
]));
```

## Extending Constructors

Custom constructors stay lightweight and delegate to fromArray:

```php
public static function fromModel(User $user): static
{
	return static::fromArray([
		'name' => $user->name,
		'bio' => $user->bio,
	]);
}
```

## Performance Notes

- Reflection is only used to map constructor parameters and cached per DTO class.
- Keep DTOs small and focused; avoid heavy transformations or database calls.
- Prefer explicit typed constructor parameters over large untyped payloads.
