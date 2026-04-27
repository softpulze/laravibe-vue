# Toast System

## Overview

The Toast module provides a typed, session-backed notification pipeline from Laravel to Vue.

Flow:

1. Create toast payloads in PHP (helpers, DTO factories, or direct DTO construction).
2. Persist to session through App\Toast\Toast.
3. Share to Inertia via HandleInertiaRequests.
4. Render in Vue with vue-sonner.

## PHP Usage

### Recommended helpers

Use the global helper functions for common toasts:

- toastSuccess(string $message, ToastActionPayload ...$actions): void
- toastError(string $message, ToastActionPayload ...$actions): void
- toastWarning(string $message, ToastActionPayload ...$actions): void
- toastInfo(string $message, ToastActionPayload ...$actions): void

Use action helpers when needed:

- toastActionCopy(string $payloadToCopy, ?string $label = null): ToastActionPayload
- toastActionRedirect(string $redirectURL, ?string $label = null): ToastActionPayload

Example:

```php
toastSuccess(
    'Profile updated successfully.',
    toastActionRedirect(route('account'), 'Open Account')
);
```

### DTO-first usage

If you need full control, append a ToastPayload manually:

```php
use App\Enums\ToastType;
use App\Toast\DTOs\ToastPayload;

$toast = new ToastPayload(
    type: ToastType::SUCCESS,
    message: 'Saved',
    actions: null,
    duration: 8000,
    dismissible: true,
);

toast()->append($toast);
```

ToastPayload supports strict hydration via fromArray and rejects unknown keys.

## Payload Contract

ToastPayload serializes to:

- type: error | success | warning | info
- message: string
- actions?: array of ToastActionPayload
- duration?: int (milliseconds)
- dismissible?: bool

ToastActionPayload serializes to:

- type: copy | redirect
- payload: string
- label?: string | null

## Queue Behavior

The backend Toast service:

- Stores toasts in session flash key: toasts
- Prevents immediate consecutive duplicate entries
- Caps queue length to 5 entries

## Vue Behavior

Frontend handling is in:

- resources/components/toast/useToast.ts
- resources/components/toast/Toast.vue
- resources/components/toast/ToastProvider.vue

Current behavior includes:

- Runtime guards for incoming toast payloads
- Idempotent toaster registration and cleanup
- Support for per-toast duration and dismissible options
- Action rendering for copy and redirect types

## Testing

Primary coverage:

- tests/Feature/Toast/ToastTest.php
- tests/Feature/Toast/HelperTest.php

Run:

```bash
php artisan test --compact tests/Feature/Toast/ToastTest.php tests/Feature/Toast/HelperTest.php
```

## Notes

- Keep ToastType and ToastActionType as the source of truth for allowed values.
- Prefer helper functions for common controller usage.
- Use DTO constructors or fromArray only when extra metadata or custom composition is required.
