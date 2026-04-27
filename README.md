<div align="center">

# LaraVibe-Vue

**A modern Laravel + Inertia.js + Vue 3 starter kit — skip the boilerplate, build your app.**

[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3-4FC08D?style=flat-square&logo=vue.js)](https://vuejs.org)
[![Inertia](https://img.shields.io/badge/Inertia.js-3-9553E9?style=flat-square)](https://inertiajs.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4-06B6D4?style=flat-square&logo=tailwindcss)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-brightgreen?style=flat-square)](LICENSE)

</div>

---

## Introduction

LaraVibe-Vue is an open-source starter kit that combines the backend power of **Laravel 13** with a fully typed **Vue 3** frontend via **Inertia.js v3** — giving you a modern SPA feel without sacrificing the simplicity of classic server-side routing and controllers.

Out of the box you get authentication, account management, an administration area, SSR support, a toast notification system, type-safe route helpers, and a curated set of developer tooling — all wired together and ready to go.

---

## Tech Stack

### Backend

| Package                                                         | Version | Purpose                               |
| --------------------------------------------------------------- | ------- | ------------------------------------- |
| [Laravel](https://laravel.com)                                  | 13      | Application framework                 |
| [Inertia Laravel](https://github.com/inertiajs/inertia-laravel) | 3       | Server-side Inertia adapter           |
| [Laravel Wayfinder](https://github.com/laravel/wayfinder)       | 0.x     | Type-safe route & action generation   |
| [Pest](https://pestphp.com)                                     | 4       | Testing framework                     |
| [Larastan](https://github.com/larastan/larastan)                | 3       | Static analysis (PHPStan for Laravel) |
| [Laravel Pint](https://laravel.com/docs/pint)                   | 1       | Opinionated PHP code formatter        |
| [Rector](https://getrector.com)                                 | 2       | Automated PHP refactoring             |
| [Laravel Sail](https://laravel.com/docs/sail)                   | 1       | Docker development environment        |
| [Laravel Pail](https://github.com/laravel/pail)                 | 1       | Real-time log tailing                 |

### Frontend

| Package                                                        | Version | Purpose                                  |
| -------------------------------------------------------------- | ------- | ---------------------------------------- |
| [Vue 3](https://vuejs.org)                                     | 3       | UI framework (Composition API)           |
| [Inertia Vue](https://inertiajs.com)                           | 3       | Client-side Inertia adapter              |
| [Tailwind CSS](https://tailwindcss.com)                        | 4       | Utility-first CSS framework              |
| [Reka UI](https://reka-ui.com)                                 | 2       | Headless UI components (shadcn-vue base) |
| [VueUse](https://vueuse.org)                                   | 12      | Vue composition utilities                |
| [Lucide Vue](https://lucide.dev)                               | latest  | Icon library                             |
| [vue-sonner](https://vue-sonner.vercel.app)                    | 2       | Toast notifications                      |
| [Vite](https://vitejs.dev)                                     | 8       | Frontend build tool                      |
| [TypeScript](https://www.typescriptlang.org)                   | 5       | Type safety                              |
| [ESLint](https://eslint.org) + [Prettier](https://prettier.io) | 9 / 3   | Linting & formatting                     |

---

## Features

### Authentication

- User registration and login
- Password reset via email
- Email verification
- Confirmable password (sudo mode) for sensitive operations

### Account Management

- **General** — update name and email address
- **Security** — change password
- **Appearance** — light/dark/system theme switcher

### Administration Area

- Protected `/administration` prefix with a ready-to-extend Dashboard page

### Developer Experience

- **Laravel Wayfinder** — auto-generated, fully-typed TypeScript functions for every controller action and named route. No more hardcoded URLs on the frontend.
- **SSR out of the box** — server-side rendering powered by `@inertiajs/vite` with cluster mode.
- **Toast notification system** — a first-class PHP `Toast` facade/helper flashes notifications that surface automatically in Vue via `vue-sonner`.
- **LaraTweaks** — opinionated Laravel defaults applied at boot: strict Eloquent mode, `CarbonImmutable` dates, HTTPS-forced URLs, Vite asset prefetching, and destructive command protection in production.
- **Global helper functions** — `vue()`, `optionalProp()`, `deferProp()`, `alwaysProp()`, `authUser()` to keep controllers clean and expressive.
- **Action conventions and usage guide** — see `app/Actions/README.md`.
- **PageMeta DTO** — pass page titles and meta from the server to Vue in a typed, consistent way.
- **Breadcrumbs DTO** — a structured way to define breadcrumb trails server-side.
- **DTO conventions and usage guide** — see `app/DTOs/README.md`.
- **HTTP resource conventions and usage guide** — see `app/Http/Resources/README.md`.
- **shadcn-vue component library** — pre-configured via `components.json` and `reka-ui`.

### Project Structure

```
app/
├── Actions/            # Single-responsibility action classes
├── DTOs/               # Typed data transfer objects (PageMeta, BreadCrumb)
├── Enums/              # Backed enums (ToastType, ToastActionType)
├── Http/
│   ├── Controllers/    # Auth & Account controllers
│   ├── Middleware/     # Custom middleware
│   ├── Requests/       # Form request validation
│   └── Resources/      # Eloquent API resources and shared concerns
├── Models/             # Eloquent models
├── Support/            # Helpers, LaraTweaks, CarbonImmutable
├── Toast/              # Self-contained toast notification system
└── Traits/             # Reusable traits (ArrayableEnum)

resources/
├── components/         # Shared Vue components & shadcn-vue UI
├── composables/        # Vue composables (useAuth, useAppearance, …)
├── layouts/            # Page layouts (Account, Auth, Guest, Administration)
├── views/              # Inertia pages (auth/, account/, administration/)
├── wayfinder/          # Auto-generated Wayfinder route/action files
└── app.ts              # Frontend entry point
```

---

## Requirements

- PHP **8.4+**
- Composer
- Node.js **20+** & npm
- SQLite / MySQL / PostgreSQL

---

## Installation

### 1. Create the project

```bash
composer create-project softpulze/laravibe-vue my-app
cd my-app
```

Or clone the repository:

```bash
git clone https://github.com/softpulze/laravibe-vue.git my-app
cd my-app
cp .env.example .env
composer install
php artisan key:generate
```

### 2. Configure your environment

Edit `.env` and set your database connection (SQLite is the default):

```env
DB_CONNECTION=sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=laravibe
# DB_USERNAME=root
# DB_PASSWORD=
```

Set your application URL and mail settings as needed.

### 3. Run migrations

```bash
php artisan migrate
```

### 4. Install frontend dependencies

```bash
npm install
```

### 5. Start the development server

```bash
composer dev
```

This starts Vite, queue listener, and Pail log watcher concurrently.

If you are using Laravel Herd, open your local Herd URL (for example: `https://my-app.test`).
If you are not using Herd, run `php artisan serve` in another terminal.

---

## Available Scripts

### PHP / Composer

| Command                          | Description                           |
| -------------------------------- | ------------------------------------- |
| `composer dev`                   | Start Vite + queue + pail together    |
| `composer test`                  | Run Pest with compact coverage output |
| `composer pint`                  | Format PHP code with Laravel Pint     |
| `composer pint:check`            | Check PHP formatting with Pint        |
| `composer phpstan`               | Run Larastan static analysis          |
| `composer rector`                | Run Rector refactoring                |
| `composer lint`                  | Run Rector + ESLint                   |
| `composer format`                | Run Pint + Prettier                   |
| `composer format:check`          | Check Pint + Prettier                 |
| `composer review`                | Run lint + format + test + phpstan    |
| `composer build`                 | Build frontend assets                 |
| `composer build:ssr`             | Build frontend + SSR bundle           |
| `composer deps:update`           | Update Composer and npm dependencies  |
| `composer logs:delete`           | Clear log files in storage/logs       |
| `php artisan wayfinder:generate` | Regenerate Wayfinder TypeScript files |

### Node / npm

| Command                | Description                              |
| ---------------------- | ---------------------------------------- |
| `npm run dev`          | Start the Vite development server        |
| `npm run build`        | Build frontend assets for production     |
| `npm run build:ssr`    | Build frontend + SSR bundle              |
| `npm run lint`         | Lint with ESLint (auto-fix)              |
| `npm run format`       | Format frontend files with Prettier      |
| `npm run format:check` | Check formatting without writing changes |

---

## Using Laravel Wayfinder

Wayfinder auto-generates typed TypeScript helpers for all your controllers and named routes. After adding a new controller or route, regenerate them:

```bash
php artisan wayfinder:generate
```

Import and use them in your Vue components:

```ts
import { AccountController } from '@/actions/Account/AccountController'
import { route } from '@/routes/web'

// In a template
<Link :href="AccountController.edit().url()">Account</Link>
```

---

## Toast Notifications

Flash a toast from any controller or action using the global `toast()` helper:

```php
use App\Toast\Toast;

toast()->success('Profile updated.');
toast()->error('Something went wrong.');
toast()->warning('Check your input.');
```

Toasts are automatically forwarded to the Vue frontend via Inertia shared data and rendered by `vue-sonner`.

---

## Testing

Tests are written with **Pest 4**. Run the full suite:

```bash
php artisan test --compact
```

Run a specific test file or filter by name:

```bash
php artisan test --compact --filter=AccountController
```

---

## Code Quality

This project enforces code quality through three tools:

```bash
# Format PHP code
vendor/bin/pint

# Static analysis
vendor/bin/phpstan analyse

# Automated refactoring
vendor/bin/rector
```

For frontend code:

```bash
npm run lint      # ESLint
npm run format    # Prettier
```

---

## Docker (Laravel Sail)

If you prefer Docker, Laravel Sail is included:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm run dev
```

---

## Deployment

LaraVibe-Vue can be deployed to any environment that supports PHP 8.4. For the fastest path to production, use [Laravel Cloud](https://cloud.laravel.com/).

Before deploying, build your frontend assets and run:

```bash
npm run build:ssr   # build with SSR support
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Contributing

Contributions are welcome! Please open an issue or pull request on GitHub.

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Commit your changes
4. Push and open a pull request

---

## License

LaraVibe-Vue is open-sourced software licensed under the [MIT license](LICENSE).
