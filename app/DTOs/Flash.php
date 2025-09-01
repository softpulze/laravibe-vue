<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\FlashType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * @phpstan-type FlashItemsShape array<int, array<string, mixed>>
 *
 * @implements Arrayable<string, mixed>
 */
final class Flash implements Arrayable, Jsonable
{
    public const KEY = 'flash';

    /**
     * Create a new class instance.
     */
    public function __construct(
        public FlashType $type,
        public string $message,
        /** @var array<int, FlashAction>|null */
        public ?array $actions = null,
    ) {
        // ...
    }

    /**
     * @return FlashItemsShape
     */
    public static function pull(): array
    {
        /** @var FlashItemsShape */
        return session()->pull(self::KEY, []);
    }

    public static function append(self $newFlash): void
    {
        /** @var FlashItemsShape $flash */
        $flash = session()->get(self::KEY, []);
        $flash[] = $newFlash->toArray();
        session()->flash(self::KEY, $flash);
    }

    public static function error(string $message, FlashAction ...$actions): void
    {
        self::append(new self(FlashType::ERROR, $message, self::ensureActionsOrNull($actions)));
    }

    public static function success(string $message, FlashAction ...$actions): void
    {
        self::append(new self(FlashType::SUCCESS, $message, self::ensureActionsOrNull($actions)));
    }

    public static function warning(string $message, FlashAction ...$actions): void
    {
        self::append(new self(FlashType::WARNING, $message, self::ensureActionsOrNull($actions)));
    }

    public static function info(string $message, FlashAction ...$actions): void
    {
        self::append(new self(FlashType::INFO, $message, self::ensureActionsOrNull($actions)));
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $flashArray = [
            'type' => $this->type->value,
            'message' => $this->message,
        ];

        if (is_array($this->actions) && count($this->actions) > 0) {
            $flashArray['actions'] = array_map(fn (FlashAction $action): array => $action->toArray(), $this->actions);
        }

        return $flashArray;
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        return (string) json_encode($this->toArray(), $options);
    }

    /**
     * @param  array<int|string, FlashAction>  $actions
     * @return array<int, FlashAction>|null
     */
    private static function ensureActionsOrNull(array $actions): ?array
    {
        return count($actions) !== 0 ? array_values($actions) : null;
    }
}
