<?php

declare(strict_types=1);

namespace App\Traits;

trait ArrayableEnum
{
    public function label(): string
    {
        return str($this->name)
            ->replace('_', ' ')
            ->title()
            ->toString();
    }

    /**
     * @return array{name: string, value: int|string, label: string}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value ?? $this->name,
            'label' => $this->label(),
        ];
    }
}
