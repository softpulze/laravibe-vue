<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * @mixin User
 */
final class UserResource extends AppResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            $this->id(),

            $this->attribute('name'),
            $this->attribute('email'),

            $this->optionalDateTimeAttributes('email_verified_at'),
            $this->optionalAttribute('remember_token'),

            ...$this->timestamps(),
        ];
    }
}
