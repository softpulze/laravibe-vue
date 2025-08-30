<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

final readonly class BreadCrumb implements Arrayable, Jsonable
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $label,
        public ?string $href = null,
    ) {
        // ...
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'href' => $this->href,
        ];
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        return (string) json_encode($this->toArray(), $options);
    }
}
