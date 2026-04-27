<?php

declare(strict_types=1);

namespace Tests\Unit\Enum;

use App\Enums\Concerns\HasEnumMetadata;

enum UnitMetaEnum
{
    use HasEnumMetadata;

    case LOW;
    case HIGH_PRIORITY;
}
