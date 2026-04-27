<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\Resources\Concerns\FlexibleJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AppResource extends JsonResource
{
    use FlexibleJsonResource;

    /**
     * Resolve the resource to a plain array for Inertia props.
     *
     * @return array<int|string, mixed>
     */
    final public function toInertia(): array
    {
        return $this->resolve();
    }

    /**
     * Create a new resource collection instance.
     */
    protected static function newCollection($resource): AppResourceCollection
    {
        return new AppResourceCollection($resource, static::class);
    }
}
