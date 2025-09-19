<?php

declare(strict_types=1);

namespace App\Toast;

use App\Toast\DTOs\ToastPayload;

/**
 * @phpstan-import-type ToastItemsShape from ToastPayload
 */
final class Toast
{
    public const KEY = 'toasts';

    /**
     * @return ToastItemsShape
     */
    public function pull(): array
    {
        /** @var ToastItemsShape */
        return session()->pull(self::KEY, []);
    }

    public function append(ToastPayload $newToast): void
    {
        /** @var ToastItemsShape $toast */
        $toast = session()->get(self::KEY, []);
        $toast[] = $newToast->toArray();
        session()->flash(self::KEY, $toast);
    }
}
