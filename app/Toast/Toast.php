<?php

declare(strict_types=1);

namespace App\Toast;

use App\Toast\DTOs\ToastPayload;

final class Toast
{
    public const KEY = 'toasts';

    private const MAX_QUEUE_ITEMS = 5;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function pull(): array
    {
        /** @var array<int, array<string, mixed>> */
        return session()->pull(self::KEY, []);
    }

    public function append(ToastPayload $newToast): void
    {
        /** @var array<int, array<string, mixed>> $toast */
        $toast = session()->get(self::KEY, []);

        $serializedToast = $newToast->toArray();
        $latestToast = $toast[count($toast) - 1] ?? null;

        if (is_array($latestToast) && $latestToast === $serializedToast) {
            return;
        }

        $toast[] = $serializedToast;

        if (count($toast) > self::MAX_QUEUE_ITEMS) {
            /** @var array<int, array<string, mixed>> $toast */
            $toast = array_slice($toast, -self::MAX_QUEUE_ITEMS);
        }

        session()->flash(self::KEY, $toast);
    }
}
