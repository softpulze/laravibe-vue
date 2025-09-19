<?php

declare(strict_types=1);

namespace App\Toast\DTOs;

use App\Enums\ToastActionType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class ToastActionPayload implements Arrayable, Jsonable
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ToastActionType $type,
        public string $payload,
        public ?string $label = null,
    ) {
        // ...
    }

    public static function copy(string $payloadToCopy, ?string $label = null): self
    {
        return new self(ToastActionType::COPY, $payloadToCopy, $label);
    }

    public static function redirect(string $redirectURL, ?string $label = null): self
    {
        return new self(ToastActionType::REDIRECT, $redirectURL, $label);
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'payload' => $this->payload,
            'label' => $this->label,
        ];
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        return (string) json_encode($this->toArray(), $options);
    }
}
