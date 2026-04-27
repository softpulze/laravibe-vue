<?php

declare(strict_types=1);

namespace App\DTOs\Concerns;

use BackedEnum;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Http\Request;
use InvalidArgumentException;
use JsonException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use UnitEnum;

/**
 * @phpstan-type DTOParameterMetadata array{
 *     name: string,
 *     hasDefault: bool,
 *     default: mixed,
 *     allowsNull: bool,
 *     builtinTypes: array<int, string>,
 *     classTypes: array<int, class-string>
 * }
 * @phpstan-type DTOConstructorMetadata array{
 *     parameters: array<int, DTOParameterMetadata>,
 *     allowedKeys: array<string, true>
 * }
 */
trait AsDTO
{
    /**
     * @param  array<string, mixed>|Request  $data
     */
    public static function from(array|Request $data): static
    {
        if ($data instanceof Request) {
            return static::fromRequest($data);
        }

        return static::fromArray($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $metadata = static::constructorMetadata();

        if (static::shouldThrowOnUnknownKeys()) {
            $unknownKeys = array_diff_key($data, $metadata['allowedKeys']);

            if ($unknownKeys !== []) {
                $keys = implode(', ', array_keys($unknownKeys));

                throw new InvalidArgumentException('Unknown properties for ' . static::class . ': ' . $keys . '.');
            }
        }

        $arguments = [];

        foreach ($metadata['parameters'] as $parameter) {
            $name = $parameter['name'];

            if (! array_key_exists($name, $data)) {
                if ($parameter['hasDefault']) {
                    $arguments[] = $parameter['default'];

                    continue;
                }

                if ($parameter['allowsNull']) {
                    $arguments[] = null;

                    continue;
                }

                throw new InvalidArgumentException('Missing required property [' . $name . '] for ' . static::class . '.');
            }

            $arguments[] = static::castValue($data[$name], $parameter);
        }

        /** @var static $dto */
        $dto = new ReflectionClass(static::class)->newInstanceArgs($arguments);

        return $dto;
    }

    public static function fromRequest(Request $request): static
    {
        $payload = method_exists($request, 'validated') ? $request->validated() : $request->all();

        if (! is_array($payload)) {
            throw new InvalidArgumentException('Request payload must be an array for ' . static::class . '.');
        }

        /** @var array<string, mixed> $payload */

        return static::fromArray($payload);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        /** @var array<string, mixed> $values */
        $values = get_object_vars($this);

        /** @var array<string, mixed> $normalized */
        $normalized = static::normalizeValueForArray($values);

        return $normalized;
    }

    public function toJson($options = 0): string // @pest-ignore-type
    {
        try {
            return json_encode($this->toArray(), $options | JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new InvalidArgumentException('Failed to encode DTO [' . static::class . '] to JSON: ' . $exception->getMessage(), 0, $exception);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toEloquent(): array
    {
        /** @var array<string, mixed> $values */
        $values = get_object_vars($this);

        /** @var array<string, mixed> $normalized */
        $normalized = static::normalizeValueForEloquent($values);

        return $normalized;
    }

    /**
     * @param  array<string, mixed>  $extra
     * @return array<string, mixed>
     */
    public function forEloquent(array $extra = []): array
    {
        return [...$this->toEloquent(), ...$extra];
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    public function with(array $overrides): static
    {
        /** @var array<string, mixed> $payload */
        $payload = [...$this->toArray(), ...$overrides];

        return static::fromArray($payload);
    }

    protected static function shouldThrowOnUnknownKeys(): bool
    {
        return false;
    }

    /** @return DTOConstructorMetadata */
    private static function constructorMetadata(): array
    {
        $metadataCache = &static::constructorMetadataStore();

        if (array_key_exists(static::class, $metadataCache)) {
            return $metadataCache[static::class];
        }

        $reflection = new ReflectionClass(static::class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            $metadataCache[static::class] = [
                'parameters' => [],
                'allowedKeys' => [],
            ];

            return $metadataCache[static::class];
        }

        $parameters = [];
        $allowedKeys = [];

        foreach ($constructor->getParameters() as $parameter) {
            $typeInfo = static::resolveTypeInfo($parameter->getType());
            $name = $parameter->getName();

            $parameters[] = [
                'name' => $name,
                'hasDefault' => $parameter->isDefaultValueAvailable(),
                'default' => $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null,
                'allowsNull' => $parameter->allowsNull(),
                'builtinTypes' => $typeInfo['builtinTypes'],
                'classTypes' => $typeInfo['classTypes'],
            ];

            $allowedKeys[$name] = true;
        }

        $metadataCache[static::class] = [
            'parameters' => $parameters,
            'allowedKeys' => $allowedKeys,
        ];

        return $metadataCache[static::class];
    }

    /**
     * @return array<class-string, DTOConstructorMetadata>
     */
    private static function &constructorMetadataStore(): array
    {
        /** @var array<class-string, DTOConstructorMetadata> $cache */
        static $cache = [];

        return $cache;
    }

    /**
     * @return array{builtinTypes: array<int, string>, classTypes: array<int, class-string>}
     */
    private static function resolveTypeInfo(?ReflectionType $type): array
    {
        if (! $type instanceof ReflectionType) {
            return [
                'builtinTypes' => [],
                'classTypes' => [],
            ];
        }

        $builtinTypes = [];
        $classTypes = [];

        if ($type instanceof ReflectionNamedType) {
            if ($type->isBuiltin()) {
                $builtinTypes[] = $type->getName();
            } else {
                /** @var class-string $name */
                $name = $type->getName();
                $classTypes[] = $name;
            }
        }

        if ($type instanceof ReflectionUnionType) {
            foreach ($type->getTypes() as $unionType) {
                if (! $unionType instanceof ReflectionNamedType) {
                    continue;
                }

                if ($unionType->isBuiltin()) {
                    $builtinTypes[] = $unionType->getName();
                } else {
                    /** @var class-string $name */
                    $name = $unionType->getName();
                    $classTypes[] = $name;
                }
            }
        }

        return [
            'builtinTypes' => array_values(array_unique($builtinTypes)),
            'classTypes' => array_values(array_unique($classTypes)),
        ];
    }

    /** @param  DTOParameterMetadata  $parameter */
    private static function castValue(mixed $value, array $parameter): mixed
    {
        if ($value === null) {
            if ($parameter['allowsNull']) {
                return null;
            }

            throw new InvalidArgumentException('Property [' . $parameter['name'] . '] on ' . static::class . ' does not allow null.');
        }

        $typedValue = static::castBuiltinValue($value, $parameter);

        if ($typedValue['matched']) {
            return $typedValue['value'];
        }

        $typedValue = static::castClassValue($value, $parameter);

        if ($typedValue['matched']) {
            return $typedValue['value'];
        }

        if ($parameter['builtinTypes'] === [] && $parameter['classTypes'] === []) {
            return $value;
        }

        $expectedTypes = implode('|', [...$parameter['builtinTypes'], ...$parameter['classTypes']]);

        throw new InvalidArgumentException('Invalid type for property [' . $parameter['name'] . '] on ' . static::class . '. Expected [' . $expectedTypes . '], got [' . static::valueType($value) . '].');
    }

    /**
     * @param  DTOParameterMetadata  $parameter
     * @return array{matched: bool, value: mixed}
     */
    private static function castBuiltinValue(mixed $value, array $parameter): array
    {
        foreach ($parameter['builtinTypes'] as $builtinType) {
            switch ($builtinType) {
                case 'int':
                    if (is_int($value)) {
                        return ['matched' => true, 'value' => $value];
                    }

                    if (is_string($value) && filter_var($value, FILTER_VALIDATE_INT) !== false) {
                        return ['matched' => true, 'value' => (int) $value];
                    }

                    break;
                case 'float':
                    if (is_float($value) || is_int($value)) {
                        return ['matched' => true, 'value' => (float) $value];
                    }

                    if (is_string($value) && is_numeric($value)) {
                        return ['matched' => true, 'value' => (float) $value];
                    }

                    break;
                case 'bool':
                    if (is_bool($value)) {
                        return ['matched' => true, 'value' => $value];
                    }

                    if (is_string($value) || is_int($value)) {
                        $bool = filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);

                        if ($bool !== null) {
                            return ['matched' => true, 'value' => $bool];
                        }
                    }

                    break;
                case 'string':
                    if (is_string($value)) {
                        return ['matched' => true, 'value' => $value];
                    }

                    if (is_int($value) || is_float($value) || is_bool($value)) {
                        return ['matched' => true, 'value' => (string) $value];
                    }

                    break;
                case 'array':
                    if (is_array($value)) {
                        return ['matched' => true, 'value' => $value];
                    }

                    break;
                case 'mixed':
                    return ['matched' => true, 'value' => $value];
            }
        }

        return ['matched' => false, 'value' => $value];
    }

    /**
     * @param  DTOParameterMetadata  $parameter
     * @return array{matched: bool, value: mixed}
     */
    private static function castClassValue(mixed $value, array $parameter): array
    {
        foreach ($parameter['classTypes'] as $classType) {
            if ($value instanceof $classType) {
                return ['matched' => true, 'value' => $value];
            }

            if (is_array($value) && method_exists($classType, 'fromArray')) {
                return ['matched' => true, 'value' => $classType::fromArray($value)];
            }

            if (is_a($classType, DateTimeInterface::class, true)) {
                if ($value instanceof DateTimeInterface) {
                    return ['matched' => true, 'value' => static::castDateTimeClass($value, $classType)];
                }

                if (is_string($value) || is_int($value)) {
                    return ['matched' => true, 'value' => static::castDateTimeClass(new DateTimeImmutable((string) $value), $classType)];
                }
            }

            if (is_subclass_of($classType, BackedEnum::class) && (is_string($value) || is_int($value))) {
                $enum = $classType::tryFrom($value);

                if ($enum instanceof BackedEnum) {
                    return ['matched' => true, 'value' => $enum];
                }
            }

            if (is_subclass_of($classType, UnitEnum::class) && is_string($value)) {
                foreach ($classType::cases() as $case) {
                    if ($case->name === $value) {
                        return ['matched' => true, 'value' => $case];
                    }
                }
            }
        }

        return ['matched' => false, 'value' => $value];
    }

    /**
     * @param  class-string  $targetClass
     */
    private static function castDateTimeClass(DateTimeInterface $dateTime, string $targetClass): DateTimeInterface
    {
        if ($dateTime instanceof $targetClass) {
            return $dateTime;
        }

        if ($targetClass === DateTimeInterface::class) {
            return $dateTime;
        }

        if (method_exists($targetClass, 'createFromInterface')) {
            /** @var DateTimeInterface $converted */
            $converted = $targetClass::createFromInterface($dateTime);

            return $converted;
        }

        return new DateTimeImmutable($dateTime->format(DATE_ATOM));
    }

    private static function valueType(mixed $value): string
    {
        if (is_object($value)) {
            return $value::class;
        }

        return gettype($value);
    }

    private static function normalizeValueForArray(mixed $value): mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof UnitEnum) {
            return $value->name;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format(DATE_ATOM);
        }

        if (is_object($value) && method_exists($value, 'toArray')) {
            /** @var mixed $normalized */
            $normalized = $value->toArray();

            return $normalized;
        }

        if (is_array($value)) {
            $normalized = [];

            foreach ($value as $key => $item) {
                $normalized[$key] = static::normalizeValueForArray($item);
            }

            return $normalized;
        }

        return $value;
    }

    private static function normalizeValueForEloquent(mixed $value): mixed
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof UnitEnum) {
            return $value->name;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if (is_object($value) && method_exists($value, 'toEloquent')) {
            /** @var mixed $normalized */
            $normalized = $value->toEloquent();

            return $normalized;
        }

        if (is_object($value) && method_exists($value, 'toArray')) {
            /** @var mixed $normalized */
            $normalized = $value->toArray();

            return $normalized;
        }

        if (is_array($value)) {
            $normalized = [];

            foreach ($value as $key => $item) {
                $normalized[$key] = static::normalizeValueForEloquent($item);
            }

            return $normalized;
        }

        return $value;
    }
}
