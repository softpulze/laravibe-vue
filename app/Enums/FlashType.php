<?php

declare(strict_types=1);

namespace App\Enums;

enum FlashType: string
{
    case ERROR = 'error';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case INFO = 'info';
}
