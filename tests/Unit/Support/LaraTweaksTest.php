<?php

declare(strict_types=1);

use App\Support\CarbonImmutable;
use App\Support\LaraTweaks;
use Illuminate\Support\Facades\Date;

test('ensures Date now use App\Support\CarbonImmutable classe', function () {
    LaraTweaks::date();

    $date = Date::parse('2025-01-01 12:00 PM');
    expect($date)->toBeInstanceOf(CarbonImmutable::class)
        ->toStringDate()->toBe('2025-01-01')
        ->toStringTime()->toBe('12:00 PM')
        ->toStringDatetime()->toBe('2025-01-01 12:00 PM');
});
