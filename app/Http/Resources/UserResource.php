<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use App\Support\CarbonImmutable;
use App\Traits\FlexibleJsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
final class UserResource extends JsonResource
{
    use FlexibleJsonResource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            $this->id(),

            $this->attribute('name'),
            $this->attribute('email'),

            $this->optionalAttribute('email_verified_at',
                fn (?CarbonImmutable $deleted_at): ?string => $deleted_at?->toStringDatetime()
            ),
            $this->optionalAttribute('remember_token'),

            $this->createdAt(),
            $this->updatedAt(),
        ];
    }
}
