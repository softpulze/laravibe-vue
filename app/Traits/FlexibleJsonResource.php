<?php

declare(strict_types=1);

namespace App\Traits;

use App\Support\CarbonImmutable;
use Closure;
use Illuminate\Http\Resources\MergeValue;
use Illuminate\Http\Resources\MissingValue;

/**
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
trait FlexibleJsonResource
{
    protected function attribute(
        string $key, bool $optional = false,
        ?Closure $resolver = null,
        ?string $alias = null,
        string $prefix = ''
    ): MergeValue|MissingValue {
        $attributePresent = array_key_exists($key, $this->getAttributes());

        /** @var MergeValue|MissingValue */
        return $this->mergeWhen(! $optional || $attributePresent, fn () => [
            $prefix . ($alias !== null && $alias !== '' && $alias !== '0' ? $alias : $key) => $resolver instanceof Closure ? $resolver($this->{$key}) : $this->{$key},
        ]);
    }

    protected function optionalAttribute(
        string $key,
        ?Closure $resolver = null,
        ?string $alias = null,
        string $prefix = ''
    ): MergeValue|MissingValue {
        return $this->attribute($key, true, $resolver, $alias, $prefix);
    }

    protected function id(): MergeValue
    {
        /** @var MergeValue */
        return $this->attribute('id');
    }

    protected function createdAt(): MergeValue|MissingValue
    {
        return $this->attribute('created_at', true, fn (CarbonImmutable $deleted_at): string => $deleted_at->toStringDatetime());
    }

    protected function updatedAt(): MergeValue|MissingValue
    {
        return $this->attribute('updated_at', true, fn (CarbonImmutable $deleted_at): string => $deleted_at->toStringDatetime());
    }

    protected function deletedAt(): MergeValue|MissingValue
    {
        return $this->attribute('deleted_at', true, fn (?CarbonImmutable $deleted_at): ?string => $deleted_at?->toStringDatetime());
    }
}
