<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

final class PageMeta implements Arrayable, Jsonable
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $heading = '',
        public string $subheading = '',

        // SEO
        public string $title = '',
    ) {
        // ...
    }

    /**
     * Convert the page meta information to a response array with a 'meta' wrapper.
     *
     * @return array{meta: array<string, mixed>}
     */
    public function toResponse(): array
    {
        return [
            'meta' => $this->toArray(),
        ];
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'heading' => $this->heading,
            'subheading' => $this->subheading,

            'title' => $this->title,
        ]);
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        return (string) json_encode($this->toArray(), $options);
    }
}
