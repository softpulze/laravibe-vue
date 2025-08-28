<?php

declare(strict_types=1);

namespace App\Support;

use Carbon\CarbonImmutable as BaseCarbonImmutable;
use Carbon\CarbonInterface;

final class CarbonImmutable extends BaseCarbonImmutable implements CarbonInterface
{
    public function toStringDate(): string
    {
        return $this->format('Y-m-d');
    }

    public function toStringTime(): string
    {
        return $this->format('h:i A');
    }

    public function toStringDatetime(): string
    {
        return $this->format('Y-m-d h:i A');
    }
}
