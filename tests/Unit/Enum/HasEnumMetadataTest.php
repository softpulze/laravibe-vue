<?php

declare(strict_types=1);

use Tests\Unit\Enum\BackedMetaEnum;
use Tests\Unit\Enum\UnitMetaEnum;

test('supports label and toOption metadata shape', function (): void {
    expect(BackedMetaEnum::IN_PROGRESS->label())->toBe('In Progress')
        ->and(BackedMetaEnum::IN_PROGRESS->toOption())->toBe([
            'name' => 'IN_PROGRESS',
            'value' => 'in_progress',
            'label' => 'In Progress',
        ]);
});

test('returns options, values, and names for backed enums', function (): void {
    expect(BackedMetaEnum::options())->toBe([
        [
            'name' => 'PENDING',
            'value' => 'pending',
            'label' => 'Pending',
        ],
        [
            'name' => 'IN_PROGRESS',
            'value' => 'in_progress',
            'label' => 'In Progress',
        ],
    ])
        ->and(BackedMetaEnum::values())->toBe(['pending', 'in_progress'])
        ->and(BackedMetaEnum::names())->toBe(['PENDING', 'IN_PROGRESS']);
});

test('validates names and values and resolves from value', function (): void {
    expect(BackedMetaEnum::isValidValue('pending'))->toBeTrue()
        ->and(BackedMetaEnum::isValidValue('missing'))->toBeFalse()
        ->and(BackedMetaEnum::isValidName('PENDING'))->toBeTrue()
        ->and(BackedMetaEnum::isValidName('pending'))->toBeTrue()
        ->and(BackedMetaEnum::isValidName('MISSING'))->toBeFalse()
        ->and(BackedMetaEnum::fromValueOrFail('pending'))->toBe(BackedMetaEnum::PENDING);
});

test('resolves unit enums from names and supports tryFromName', function (): void {
    expect(UnitMetaEnum::values())->toBe(['LOW', 'HIGH_PRIORITY'])
        ->and(UnitMetaEnum::fromValueOrFail('LOW'))->toBe(UnitMetaEnum::LOW)
        ->and(UnitMetaEnum::tryFromName('high_priority'))->toBe(UnitMetaEnum::HIGH_PRIORITY)
        ->and(UnitMetaEnum::tryFromName('missing'))->toBeNull();
});

test('throws a clear exception for invalid fromValueOrFail input', function (): void {
    BackedMetaEnum::fromValueOrFail('invalid');
})->throws(InvalidArgumentException::class, 'Invalid enum value [invalid]');
