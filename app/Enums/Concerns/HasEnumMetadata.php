<?php

declare(strict_types=1);

namespace App\Enums\Concerns;

use BackedEnum;
use InvalidArgumentException;

trait HasEnumMetadata
{
    /**
     * @return array<int, array{name: string, value: int|string, label: string}>
     */
    public static function options(): array
    {
        return array_map(static fn (self $case): array => $case->toOption(), self::cases());
    }

    /**
     * @return array<int, int|string>
     */
    public static function values(): array
    {
        return array_map(static::extractValue(...), self::cases());
    }

    /**
     * @return array<int, string>
     */
    public static function names(): array
    {
        return array_map(static fn (self $case): string => $case->name, self::cases());
    }

    public static function isValidValue(int|string $value): bool
    {
        return in_array($value, static::values(), true);
    }

    public static function isValidName(string $name): bool
    {
        return static::tryFromName($name) !== null;
    }

    public static function fromValueOrFail(int|string $value): self
    {
        if (is_subclass_of(static::class, BackedEnum::class)) {
            /** @var self|null $case */
            $case = static::tryFrom($value);

            if ($case !== null) {
                return $case;
            }
        }

        $case = static::tryFromName((string) $value);

        if ($case !== null) {
            return $case;
        }

        throw new InvalidArgumentException(sprintf('Invalid enum value [%s] for [%s].', (string) $value, static::class));
    }

    public static function tryFromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if (strcasecmp((string) $case->name, $name) === 0) {
                return $case;
            }
        }

        return null;
    }

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
    public function toOption(): array
    {
        return [
            'name' => $this->name,
            'value' => static::extractValue($this),
            'label' => $this->label(),
        ];
    }

    private static function extractValue(self $case): int|string
    {
        if ($case instanceof BackedEnum) {
            return $case->value;
        }

        return $case->name;
    }
}
