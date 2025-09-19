<?php

declare(strict_types=1);

namespace App\Enums;

enum ToastActionType: string
{
    case COPY = 'copy';
    case REDIRECT = 'redirect';
}
