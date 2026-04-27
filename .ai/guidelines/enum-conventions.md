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
