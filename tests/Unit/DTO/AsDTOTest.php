<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

use Illuminate\Http\Request;
use InvalidArgumentException;

it('hydrates from array with safe scalar casting', function (): void {
    $dto = AsDTOUserDTO::fromArray([
        'name' => 'Ashok',
        'age' => '31',
        'active' => 'false',
    ]);

    expect($dto->name)->toBe('Ashok')
        ->and($dto->age)->toBe(31)
        ->and($dto->active)->toBeFalse();
});

it('hydrates from request', function (): void {
    $request = Request::create('/', 'POST', [
        'name' => 'Ria',
        'age' => 22,
    ]);

    $dto = AsDTOUserDTO::from($request);

    expect($dto->name)->toBe('Ria')
        ->and($dto->age)->toBe(22)
        ->and($dto->active)->toBeTrue();
});

it('ignores unknown keys by default', function (): void {
    $dto = AsDTOUserDTO::fromArray([
        'name' => 'Lara',
        'age' => 25,
        'unknown' => 'ignored',
    ]);

    expect($dto->toArray())->toBe([
        'name' => 'Lara',
        'age' => 25,
        'active' => true,
        'address' => null,
    ]);
});

it('throws for unknown keys when strict mode is enabled', function (): void {
    AsDTOStrictDTO::fromArray([
        'title' => 'Hello',
        'extra' => 'Not allowed',
    ]);
})->throws(InvalidArgumentException::class, 'Unknown properties');

it('throws a clear error for missing required properties', function (): void {
    AsDTOUserDTO::fromArray([
        'name' => 'Only Name',
    ]);
})->throws(InvalidArgumentException::class, 'Missing required property [age]');

it('throws a clear error for invalid types', function (): void {
    AsDTOUserDTO::fromArray([
        'name' => 'Ashok',
        'age' => 'invalid-int',
    ]);
})->throws(InvalidArgumentException::class, 'Invalid type for property [age]');

it('supports nested DTO hydration', function (): void {
    $dto = AsDTOUserDTO::fromArray([
        'name' => 'Nested',
        'age' => 18,
        'address' => [
            'lineOne' => 'Street 1',
            'city' => 'Dhaka',
        ],
    ]);

    expect($dto->address)->toBeInstanceOf(AsDTOAddressDTO::class)
        ->and($dto->address?->city)->toBe('Dhaka');
});

it('serializes to json and to eloquent arrays', function (): void {
    $dto = AsDTOUserDTO::fromArray([
        'name' => 'Json',
        'age' => 30,
        'address' => [
            'lineOne' => 'Main Road',
            'city' => 'Chattogram',
        ],
    ]);

    expect($dto->toJson())->toBeJson()
        ->and($dto->toEloquent())->toBe([
            'name' => 'Json',
            'age' => 30,
            'active' => true,
            'address' => [
                'lineOne' => 'Main Road',
                'city' => 'Chattogram',
            ],
        ])
        ->and($dto->forEloquent(['source' => 'test']))->toBe([
            'name' => 'Json',
            'age' => 30,
            'active' => true,
            'address' => [
                'lineOne' => 'Main Road',
                'city' => 'Chattogram',
            ],
            'source' => 'test',
        ]);
});

it('supports immutable updates with with()', function (): void {
    $dto = AsDTOUserDTO::fromArray([
        'name' => 'Before',
        'age' => 20,
    ]);

    $updated = $dto->with([
        'name' => 'After',
    ]);

    expect($updated->name)->toBe('After')
        ->and($updated->age)->toBe(20)
        ->and($dto->name)->toBe('Before');
});
