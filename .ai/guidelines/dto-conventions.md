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
