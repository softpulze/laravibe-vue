<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

final class AppResourceCollection extends ResourceCollection
{
    public function __construct(mixed $resource, ?string $collects = null)
    {
        $this->collects = $collects;

        parent::__construct($resource);
    }

    /**
     * Resolve the collection to a plain array for Inertia props.
     *
     * @return array<int|string, mixed>
     */
    public function toInertia(?Request $request = null): array
    {
        $request ??= request();

        if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
            return $this->response($request)->getData(true);
        }

        return $this->resolve($request);
    }

    /**
     * Customize paginator output for API and Inertia consumers.
     *
     * @param  array<string, mixed>  $paginated
     * @param  array<string, mixed>  $default
     * @return array<string, mixed>
     */
    public function paginationInformation(Request $request, array $paginated, array $default): array
    {
        return [
            'links' => [
                'first' => $paginated['first_page_url'] ?? null,
                'last' => $paginated['last_page_url'] ?? null,
                'prev' => $paginated['prev_page_url'] ?? null,
                'next' => $paginated['next_page_url'] ?? null,
            ],
            'meta' => [
                'current_page' => $paginated['current_page'] ?? null,
                'from' => $paginated['from'] ?? null,
                'last_page' => $paginated['last_page'] ?? null,
                'path' => $paginated['path'] ?? null,
                'per_page' => $paginated['per_page'] ?? null,
                'to' => $paginated['to'] ?? null,
                'total' => $paginated['total'] ?? null,
            ],
        ];
    }
}
