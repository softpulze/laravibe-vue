# HTTP Resources Conventions for AI Agents

## Placement Rules

- Place resources only in `app/Http/Resources`.
- Use domain subfolders for feature grouping, for example `app/Http/Resources/Admin` or `app/Http/Resources/Account`.

## Class Rules

- Every resource must be a `final class`.
- Single resources must extend `AppResource`, not `JsonResource`.
- Collection resources must extend `AppResourceCollection`.
- Implement `Illuminate\Http\Request` type-hinting in `toArray()`.

## Naming Rules

- Use singular names ending with `Resource` for single resources (e.g., `UserResource`, `PostResource`).
- Use singular or collection names ending with `Collection` for collection resources (e.g., `UserCollection`, `PostCollection`).

## Field Definition Rules

- Use the `FlexibleJsonResource` trait helpers exclusively in `toArray()`.
- Core helpers: `id()`, `attribute()`, `optionalAttribute()`, `relation()`.
- Timestamp helpers: `createdAt()`, `updatedAt()`, `deletedAt()`, `timestamps()`, `softDeleteTimestamps()`.
- Support field customization with `alias`, `prefix`, and `suffix` parameters.
- Never directly access model attributes or relations—use the trait helpers.

## Serialization Rules

- Use `toArray()` for API responses.
- Use `toInertia()` (from `AppResource` or `AppResourceCollection`) when passing to Vue components.
- Use `toInertia()` to remove JSON wrappers and return plain arrays suitable for Inertia props.
- Relations must use `relation()` to ensure they're only serialized if eager-loaded, preventing N+1 queries.

## Generation Rules

- Generate single resources with `php artisan make:resource ResourceName` (uses `stubs/resource.stub`).
- Generate collection resources with `php artisan make:resource CollectionName --collection` (uses `stubs/resource-collection.stub`).
- Generated classes follow strict types, declare(strict_types=1), and final class conventions.

## Pagination Rules

- Paginated resources are returned automatically via `AppResource::collection()` on paginated queries.
- Pagination shape includes `data`, `links` (first/last/prev/next), and `meta` (current_page, from, last_page, path, per_page, to, total).

## Design Rules

- Keep resources focused on serialization only—no business logic, queries, or transformations.
- Use Resources for data that will be shared between API and Inertia.
- For simple, single-use transforms, inline the resolver within `attribute()` instead of creating a separate method.
- Prefer eager-loading via query builder over lazy loading via `relation()`.

## Example Prompt Templates

- Create a `UserResource` that includes `id()`, `attribute('name')`, `attribute('email')`, and `timestamps()`.
- Generate a `PostCollection` resource and refactor `PostResource` to use it with pagination.
- Add a `relation()` helper for posts inside `UserResource` to prevent N+1 queries.
- Create `app/Http/Resources/Admin/AdminUserResource` that extends `AppResource` with admin-specific fields.
- Update `UserResource` to use `optionalAttribute()` for nullable fields like `email_verified_at`.
