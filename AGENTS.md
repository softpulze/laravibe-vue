<laravel-boost-guidelines>
=== .ai/action-conventions rules ===

# Action Conventions for AI Agents

## Placement Rules

- Place actions in app/Actions or app/Actions/{Domain}.
- Use domain folders for feature grouping, for example app/Actions/Account.

## Class Rules

- Every action should be a final readonly class.
- Keep one primary public method named handle unless the existing codebase uses a different convention.
- Add strict types in generated action files.

## Method Rules

- Prefer explicit parameter and return types on handle.
- Keep handle focused on a single business operation.
- Use transactions when mutating multiple related records.

## Dependency Rules

- Inject dependencies through the constructor and keep them immutable.
- Avoid resolving dependencies with app() inside handle when constructor injection is possible.

## Design Rules

- Keep validation in Form Requests, not in action classes.
- Keep actions thin and compose other actions/services where needed.
- Avoid unrelated side effects in the same action.

## Example Prompt Templates

- Create app/Actions/Account/UpdateProfileAction as final readonly with a typed handle method.
- Refactor app/Actions/Billing/CreateInvoiceAction to use constructor injection and explicit return types.
- Generate app/Actions/Payroll/SyncPayrollAction with transaction-safe updates and a single responsibility.

=== .ai/auth-conventions rules ===

# Auth Conventions for AI Agents

## Shared Props Rules

- `auth.user` must always be present in every Inertia response — use `null` for guests, never omit the key.
- `auth.can` must always be present as a flat `Record<string, boolean>` ability map.
- The default shared user payload is minimal: `id`, `name`, `email`, and optionally `email_verified_at`.
- Never include `password`, `remember_token`, or internal timestamps in the shared auth payload.
- Ability values are resolved server-side in `HandleInertiaRequests::resolveAbilities()`. Return booleans only.

## Adding Abilities Rules

- Add new ability keys to both the guest (`$user === null`) and authenticated branches of `resolveAbilities()`.
- Resolve ability values using Laravel gates or policy checks — never duplicate authorization logic on the frontend.
- Keep the ability map small and UI-focused. Backend-only authorization must stay backend-only.

## TypeScript Type Rules

- `Auth.user` must be typed as `User | null`, never `User | undefined` or `User?`.
- `Auth.can` must be typed as `Record<string, boolean>`.
- The `User` interface must exactly mirror the fields returned by `UserResource`. Do not add fields that are not serialized by the backend.
- Optional fields on `User` (such as `avatar`, `email_verified_at`) must remain optional with explicit `Nullable<T>` or `string | null` types.

## Composable Usage Rules

- Always import auth state from `useAuth` — never read `usePage().props.auth` directly in a component.
- Use `user` (nullable computed) on public pages where a visitor may or may not be authenticated.
- Use `requireUser()` on pages that are always behind an `auth` middleware. It returns a non-null `User` and eliminates optional-chaining noise.
- Use `can(ability)` for UI gating (show/hide elements). Never use it as a substitute for server-side authorization.
- Do not use `isAuthenticated` as a guard for sensitive operations — always rely on backend middleware.

## Security Rules

- Do not expose sensitive model fields (`password`, `remember_token`, internal tokens) in any shared Inertia prop.
- Ability values must be booleans. Never serialize raw policy objects, role strings, or permission arrays to the frontend.
- Client-side `can()` checks are UI conveniences only. Every sensitive action must be authorized on the server.

## Example Prompt Templates

- Add a new `manageTeam` ability to `resolveAbilities()` that checks `$user->hasTeam()` for authenticated users and returns false for guests.
- Update the `User` TypeScript interface to add an optional `phone?: string | null` field after adding it to `UserResource`.
- Use `requireUser()` in a new protected Vue page to access the authenticated user without optional chaining.
- Add `can('publishPost')` gating to hide a publish button for users who lack the ability.

=== .ai/dto-conventions rules ===

# DTO Conventions for AI Agents

## Placement Rules

- Place DTOs only in app/DTOs or app/DTOs/{Domain}.
- Use domain folders for feature grouping, for example app/DTOs/Billing or app/DTOs/Account.

## Class Rules

- Every DTO must be a final readonly class.
- Every DTO must use App\DTOs\Concerns\AsDTO.
- DTO classes should implement Arrayable and Jsonable when used as shared response payloads.

## Naming Rules

- Use singular names ending with DTO.
- Prefer purpose-based names such as CreateInvoiceDTO, UpdateProfileDTO, ListFiltersDTO.

## Property Typing Rules

- Constructor promotion is required.
- Use strict scalar and object types where possible.
- Keep nullable types explicit.
- Avoid mixed unless absolutely necessary.
- Required parameters must come before optional parameters.

## Hydration and Output Rules

- Hydrate DTOs with ::from(), ::fromArray(), or ::fromRequest().
- Unknown request keys are ignored by default.
- To enable strict unknown-key validation in a DTO, override protected static function shouldThrowOnUnknownKeys(): bool and return true.
- Use toArray for general serialization and toEloquent for model-friendly attributes.

## Design Rules

- Keep DTOs small and focused on transport only.
- Do not put database queries or heavy business logic inside DTOs.
- Use custom constructors like fromModel as thin wrappers that delegate to fromArray.

## Example Prompt Templates

- Create app/DTOs/Account/UpdateProfileDTO as final readonly using AsDTO with name, username, and nullable bio.
- Generate a Billing/CreateInvoiceDTO with typed properties and a fromModel helper for draft invoices.
- Refactor existing DTOs in app/DTOs to use AsDTO and replace manual toArray and toJson methods.

=== .ai/enum-conventions rules ===

# Enum Conventions for AI Agents

## Placement Rules

- Place enums in app/Enums.
- Place shared enum concerns in app/Enums/Concerns.
- Use App\Enums\Concerns\HasEnumMetadata for shared enum behavior.

## Base Concern Contract

The shared base concern must preserve exactly these 8 core methods:

1. label(): string
2. toOption(): array{name: string, value: int|string, label: string}
3. options(): array<int, array{name: string, value: int|string, label: string}>
4. values(): array<int, int|string>
5. names(): array<int, string>
6. isValidValue(int|string $value): bool
7. isValidName(string $name): bool
8. fromValueOrFail(int|string $value): self

Only one optional base method is allowed:

1. tryFromName(string $name): ?self

## Design Rules

- Keep shared enum concerns pure and deterministic.
- Do not add database calls, HTTP calls, or heavy business logic inside enum concerns.
- Put domain-specific behavior on individual enum classes.
- Keep DTO enum serialization behavior in App\DTOs\Concerns\AsDTO unchanged.

=== .ai/resource-conventions rules ===

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

=== .ai/support-conventions rules ===

# Support Conventions for AI Agents

## Scope

Use this guide when creating or modifying files under `app/Support`.

## Responsibilities

- Keep `app/Support` for cross-cutting framework support only.
- Do not move business/domain logic into this layer.
- Keep helpers small and composable.

## Date Rules

- Keep `App\Support\CarbonImmutable` as the default Date class via `Date::use()`.
- Use explicit formatter methods by intent:
    - Transport/API values: `toApiDate()`, `toApiTime()`, `toApiDatetime()`.
    - Human display values: `toStringDate()`, `toStringTime()`, `toStringDatetime()`.
- Avoid ad-hoc inline date format strings in resources if existing helper methods already cover the need.

## LaraTweaks Rules

- Register framework tweaks in `App\Support\LaraTweaks` and call from `AppServiceProvider::boot()`.
- Keep tweak methods side-effect focused and narrowly scoped.
- Preserve strict model mode and resource no-wrapping unless explicitly requested to change.

## Helper Function Rules

- Add helpers only when reused in multiple places.
- Use strict return types and clear names.
- Throw framework exceptions for invalid auth/context states instead of returning ambiguous null values.

## Editing Rules

- Follow existing file structure and naming.
- Preserve immutable date behavior.
- Update related tests whenever Support behavior changes.

=== .ai/toast-conventions rules ===

# Toast Conventions for AI Agents

## Scope Rules

- Keep all toast-related backend code in app/Toast.
- Keep toast enums in app/Enums.
- Keep frontend toast contract and rendering in resources/components/toast.

## Usage Rules

- Prefer helper functions for common toast creation:
    - toastSuccess
    - toastError
    - toastWarning
    - toastInfo
- Use toastActionCopy and toastActionRedirect for action payloads.
- Avoid ad-hoc session writes to the toasts key.

## DTO Rules

- Use App\Toast\DTOs\ToastPayload and App\Toast\DTOs\ToastActionPayload.
- Keep ToastPayload and ToastActionPayload strict and typed.
- Preserve strict unknown-key behavior for DTO hydration.
- Do not add business logic or database access inside toast DTOs.

## Contract Rules

- Allowed toast types must come from App\Enums\ToastType.
- Allowed action types must come from App\Enums\ToastActionType.
- Keep payload keys stable:
    - ToastPayload: type, message, actions?, duration?, dismissible?
    - ToastActionPayload: type, payload, label?
- Any contract change requires updating frontend types and tests in the same change.

## Backend Service Rules

- Continue using App\Toast\Toast as the only session transport layer.
- Preserve queue safeguards such as duplicate prevention and queue capping.
- Do not bypass append and pull behavior.

## Frontend Rules

- Keep runtime validation in resources/components/toast/useToast.ts.
- Keep toaster registration idempotent and cleaned up on HMR disposal.
- Ensure Toast.vue supports all action types and remains type-safe.

## Testing Rules

- Update tests when changing toast behavior:
    - tests/Feature/Toast/ToastTest.php
    - tests/Feature/Toast/HelperTest.php
- Add at least one integration-level assertion when controller behavior changes toast output.
- Run focused tests first:
    - php artisan test --compact tests/Feature/Toast/ToastTest.php tests/Feature/Toast/HelperTest.php

## Prompt Templates

- Add a new toast action type end-to-end using enum, DTO, Vue renderer, and tests.
- Add toast metadata support while keeping backward compatibility and strict hydration.
- Refactor toast helper ergonomics without changing session transport behavior.

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- inertiajs/inertia-laravel (INERTIA_LARAVEL) - v3
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/wayfinder (WAYFINDER) - v0
- larastan/larastan (LARASTAN) - v3
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- rector/rector (RECTOR) - v2
- @inertiajs/vue3 (INERTIA_VUE) - v3
- tailwindcss (TAILWINDCSS) - v4
- vue (VUE) - v3
- @laravel/vite-plugin-wayfinder (WAYFINDER_VITE) - v0
- eslint (ESLINT) - v9
- prettier (PRETTIER) - v3

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `laravel-best-practices` — Apply this skill whenever writing, reviewing, or refactoring Laravel PHP code. This includes creating or modifying controllers, models, migrations, form requests, policies, jobs, scheduled commands, service classes, and Eloquent queries. Triggers for N+1 and query performance issues, caching strategies, authorization and security patterns, validation, error handling, queue and job configuration, route definitions, and architectural decisions. Also use for Laravel code reviews and refactoring existing Laravel code to follow best practices. Covers any task involving Laravel backend PHP code patterns.
- `wayfinder-development` — Use this skill for Laravel Wayfinder which auto-generates typed functions for Laravel controllers and routes. ALWAYS use this skill when frontend code needs to call backend routes or controller actions. Trigger when: connecting any React/Vue/Svelte/Inertia frontend to Laravel controllers, routes, building end-to-end features with both frontend and backend, wiring up forms or links to backend endpoints, fixing route-related TypeScript errors, importing from @/actions or @/routes, or running wayfinder:generate. Use Wayfinder route functions instead of hardcoded URLs. Covers: wayfinder() vite plugin, .url()/.get()/.post()/.form(), query params, route model binding, tree-shaking. Do not use for backend-only task
- `pest-testing` — Use this skill for Pest PHP testing in Laravel projects only. Trigger whenever any test is being written, edited, fixed, or refactored — including fixing tests that broke after a code change, adding assertions, converting PHPUnit to Pest, adding datasets, and TDD workflows. Always activate when the user asks how to write something in Pest, mentions test files or directories (tests/Feature, tests/Unit, tests/Browser), or needs browser testing, smoke testing multiple pages for JS errors, or architecture tests. Covers: test()/it()/expect() syntax, datasets, mocking, browser testing (visit/click/fill), smoke testing, arch(), Livewire component tests, RefreshDatabase, and all Pest 4 features. Do not use for factories, seeders, migrations, controllers, models, or non-test PHP code.
- `inertia-vue-development` — Develops Inertia.js v3 Vue client-side applications. Activates when creating Vue pages, forms, or navigation; using <Link>, <Form>, useForm, useHttp, setLayoutProps, or router; working with deferred props, prefetching, optimistic updates, instant visits, or polling; or when user mentions Vue with Inertia, Vue pages, Vue forms, or Vue navigation.
- `tailwindcss-development` — Always invoke when the user's message includes 'tailwind' in any form. Also invoke for: building responsive grid layouts (multi-column card grids, product grids), flex/grid page structures (dashboards with sidebars, fixed topbars, mobile-toggle navs), styling UI components (cards, tables, navbars, pricing sections, forms, inputs, badges), adding dark mode variants, fixing spacing or typography, and Tailwind v3/v4 work. The core use case: writing or fixing Tailwind utility classes in HTML templates (Blade, JSX, Vue). Skip for backend PHP logic, database queries, API routes, JavaScript with no HTML/CSS component, CSS file audits, build tool configuration, and vanilla CSS.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== herd rules ===

# Laravel Herd

- The application is served by Laravel Herd at `https?://[kebab-case-project-dir].test`. Use the `get-absolute-url` tool to generate valid URLs. Never run commands to serve the site. It is always available.
- Use the `herd` CLI to manage services, PHP versions, and sites (e.g. `herd sites`, `herd services:start <service>`, `herd php:list`). Run `herd list` to discover all available commands.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== inertia-laravel/core rules ===

# Inertia

- Inertia creates fully client-side rendered SPAs without modern SPA complexity, leveraging existing server-side patterns.
- Components live in `resources/js/Pages` (unless specified in `vite.config.js`). Use `Inertia::render()` for server-side routing instead of Blade views.
- ALWAYS use `search-docs` tool for version-specific Inertia documentation and updated code examples.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

# Inertia v3

- Use all Inertia features from v1, v2, and v3. Check the documentation before making changes to ensure the correct approach.
- New v3 features: standalone HTTP requests (`useHttp` hook), optimistic updates with automatic rollback, layout props (`useLayoutProps` hook), instant visits, simplified SSR via `@inertiajs/vite` plugin, custom exception handling for error pages.
- Carried over from v2: deferred props, infinite scroll, merging props, polling, prefetching, once props, flash data.
- When using deferred props, add an empty state with a pulsing or animated skeleton.
- Axios has been removed. Use the built-in XHR client with interceptors, or install Axios separately if needed.
- `Inertia::lazy()` / `LazyProp` has been removed. Use `Inertia::optional()` instead.
- Prop types (`Inertia::optional()`, `Inertia::defer()`, `Inertia::merge()`) work inside nested arrays with dot-notation paths.
- SSR works automatically in Vite dev mode with `@inertiajs/vite` - no separate Node.js server needed during development.
- Event renames: `invalid` is now `httpException`, `exception` is now `networkError`.
- `router.cancel()` replaced by `router.cancelAll()`.
- The `future` configuration namespace has been removed - all v2 future options are now always enabled.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== wayfinder/core rules ===

# Laravel Wayfinder

Use Wayfinder to generate TypeScript functions for Laravel routes. Import from `@/actions/` (controllers) or `@/routes/` (named routes).

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== inertia-vue/core rules ===

# Inertia + Vue

Vue components must have a single root element.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

</laravel-boost-guidelines>
