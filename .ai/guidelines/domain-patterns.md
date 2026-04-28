# Domain Conventions Index

**Reference only what's needed. All canonical conventions live in `.ai/guidelines/` files.**

## Action Patterns
- Final readonly class
- Single `handle()` method with explicit types
- Constructor injection only (no `app()`)
- Validation → Form Requests, not Actions
- Transactions for multi-record mutations

See: `/resources/app/Actions/` for examples

## DTO Patterns  
- Final readonly class + `AsDTO` trait
- Constructor promotion required
- Explicit nullable types
- `fromArray()` / `fromRequest()` constructors
- `toArray()` for serialization

See: `/app/DTOs/` for examples

## Resource Patterns
- Final class extending `AppResource` / `AppResourceCollection`
- Use trait helpers: `id()`, `attribute()`, `relation()`, `timestamps()`
- `toArray()` for API, `toInertia()` for Vue props
- Always include foreign keys in `relation()` selects

See: `/app/Http/Resources/` for examples

## Eloquent Patterns
- Eager load with `with()` → prevent N+1
- Select only needed columns
- Local scopes for reusable constraints
- Use `whereBelongsTo()` for relationship queries
- Never hardcode table names (use `Model::getTable()`)

See: `/app/Models/User.php` for examples

## Inertia v3 Features
- `<Form>` component or `useForm()` composable for forms
- `<Link>` component for navigation (never `<a>`)
- Deferred props with loading skeleton
- Optimistic updates with `router.optimistic()`
- Use `setLayoutProps()` for layout state

See: `/resources/js/Pages/` for examples

## Testing (Pest)
- Feature tests in `tests/Feature/`
- Use `it()` or `test()` consistently (check siblings first)
- `RefreshDatabase` trait for test isolation
- `assertSuccessful()` not `assertStatus(200)`
- Mock external calls: `Http::fake()`, `Event::fake()`

See: `tests/Feature/` for examples

## Validation
- Form Requests, not inline validation
- Use `validated()` only, never `all()`
- Array notation `['required', 'email']` preferred
- Conditional rules via `Rule::when()`

See: `/app/Http/Requests/` for examples

---

**Quick Rule:** If unsure about pattern, find analogous file in same domain, follow its approach exactly.
