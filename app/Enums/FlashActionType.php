<?php

declare(strict_types=1);

namespace App\Enums;

enum FlashActionType: string
{
    case COPY = 'copy';
    case REDIRECT = 'redirect';
}
