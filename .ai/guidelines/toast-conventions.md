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
