<?php

declare(strict_types=1);

namespace App\Toast\DTOs;

use App\Enums\ToastType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * @phpstan-type ToastItemsShape array<int, array<string, mixed>>
 *
 * @implements Arrayable<string, mixed>
 */
final class ToastPayload implements Arrayable, Jsonable
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ToastType $type,
        public string $message,
        /** @var array<int, ToastActionPayload>|null */
        public ?array $actions = null,
    ) {
        // ...
    }

    public static function error(string $message, ToastActionPayload ...$actions): void
    {
        toast()->append(new self(ToastType::ERROR, $message, self::ensureActionsOrNull($actions)));
    }

    public static function success(string $message, ToastActionPayload ...$actions): void
    {
        toast()->append(new self(ToastType::SUCCESS, $message, self::ensureActionsOrNull($actions)));
    }

    public static function warning(string $message, ToastActionPayload ...$actions): void
    {
        toast()->append(new self(ToastType::WARNING, $message, self::ensureActionsOrNull($actions)));
    }

    public static function info(string $message, ToastActionPayload ...$actions): void
    {
        toast()->append(new self(ToastType::INFO, $message, self::ensureActionsOrNull($actions)));
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $toastArray = [
            'type' => $this->type->value,
            'message' => $this->message,
        ];

        if (is_array($this->actions) && count($this->actions) > 0) {
            $toastArray['actions'] = array_map(fn (ToastActionPayload $action): array => $action->toArray(), $this->actions);
        }

        return $toastArray;
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        return (string) json_encode($this->toArray(), $options);
    }

    /**
     * @param  array<int|string, ToastActionPayload>  $actions
     * @return array<int, ToastActionPayload>|null
     */
    private static function ensureActionsOrNull(array $actions): ?array
    {
        return count($actions) !== 0 ? array_values($actions) : null;
    }
}
