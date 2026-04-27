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
