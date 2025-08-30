<?php

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

final readonly class PageMeta implements Arrayable, Jsonable
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $heading = null,
        public ?string $subheading = null,

        // SEO
        public ?string $title = null,

        // Breadcrumbs
        public ?Collection $breadcrumbs = null,
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
        return array_filter([
            'heading' => $this->heading,
            'subheading' => $this->subheading,

            'title' => $this->title,

            'breadcrumbs' => $this->breadcrumbs?->toArray(),
        ]);
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        return (string) json_encode($this->toArray(), $options);
    }
}
