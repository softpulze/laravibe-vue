<?php

declare(strict_types=1);

namespace App\Http\Resources\Concerns;

use App\Support\CarbonImmutable;
use Closure;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
        string $key,
        bool $optional = false,
        ?Closure $resolver = null,
        ?string $alias = null,
        string $prefix = '',
        string $suffix = ''
    ): MergeValue|MissingValue {
        $attributePresent = array_key_exists($key, $this->getAttributes());

        /** @var MergeValue|MissingValue */
        return $this->mergeWhen(! $optional || $attributePresent, fn (): array => [
            $this->formatKey($key, $alias, $prefix, $suffix) => $this->normalizeValue(
                $resolver instanceof Closure ? $resolver($this->{$key}) : $this->{$key}
            ),
        ]);
    }

    protected function optionalAttribute(
        string $key,
        ?Closure $resolver = null,
        ?string $alias = null,
        string $prefix = '',
        string $suffix = ''
    ): MergeValue|MissingValue {
        return $this->attribute($key, true, $resolver, $alias, $prefix, $suffix);
    }

    protected function relation(
        string $key,
        ?Closure $resolver = null,
        ?string $alias = null,
        string $prefix = '',
        string $suffix = ''
    ): MergeValue|MissingValue {
        $relationLoaded = method_exists($this->resource, 'relationLoaded') && $this->resource->relationLoaded($key);

        /** @var MergeValue|MissingValue */
        return $this->mergeWhen($relationLoaded, fn (): array => [
            $this->formatKey($key, $alias, $prefix, $suffix) => $this->normalizeValue(
                $resolver instanceof Closure ? $resolver($this->{$key}) : $this->{$key}
            ),
        ]);
    }

    protected function id(): MergeValue
    {
        /** @var MergeValue */
        return $this->attribute('id');
    }

    protected function createdAt(): MergeValue|MissingValue
    {
        return $this->optionalDateTimeAttributes('created_at');
    }

    protected function updatedAt(): MergeValue|MissingValue
    {
        return $this->optionalDateTimeAttributes('updated_at');
    }

    protected function deletedAt(): MergeValue|MissingValue
    {
        return $this->optionalDateTimeAttributes('deleted_at');
    }

    protected function optionalDateTimeAttributes(string $key): MergeValue|MissingValue
    {
        $attributePresent = array_key_exists($key, $this->getAttributes());

        /** @var MergeValue|MissingValue */
        return $this->mergeWhen($attributePresent, function () use ($key): array {
            /** @var CarbonImmutable|null $dateTime */
            $dateTime = $this->{$key};

            return [
                $key => $dateTime?->toApiDatetime(),
                "{$key}_display" => $dateTime?->toStringDatetime(),
            ];
        });
    }

    /**
     * @return array<int, MergeValue|MissingValue>
     */
    protected function timestamps(): array
    {
        return [
            $this->createdAt(),
            $this->updatedAt(),
        ];
    }

    /**
     * @return array<int, MergeValue|MissingValue>
     */
    protected function softDeleteTimestamps(): array
    {
        return [
            ...$this->timestamps(),
            $this->deletedAt(),
        ];
    }

    private function formatKey(string $key, ?string $alias, string $prefix, string $suffix): string
    {
        return $prefix . (in_array($alias, [null, '', '0'], true) ? $key : $alias) . $suffix;
    }

    private function normalizeValue(mixed $value): mixed
    {
        if ($value instanceof JsonResource || $value instanceof ResourceCollection) {
            return $value->resolve();
        }

        if ($value instanceof Jsonable) {
            return json_decode($value->toJson(), true, flags: JSON_THROW_ON_ERROR);
        }

        return $value;
    }
}
