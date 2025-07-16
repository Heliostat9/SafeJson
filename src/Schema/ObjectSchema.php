<?php

namespace Heliostat\SafeJson\Schema;

use Heliostat\SafeJson\JsonSchema;
use Heliostat\SafeJson\Exception\ValidationException;
use Heliostat\SafeJson\Parser\JsonParser;

class ObjectSchema implements SchemaNode
{
    private bool $required = false;
    private mixed $default = null;

    public function __construct(
        private readonly string $schemaClass
    ) {
    }

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    public function default(mixed $default): self
    {
        $this->default = $default;
        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    public function validate(mixed $value): JsonSchema
    {
        if (!is_array($value)) {
            throw new ValidationException("Expected object (array), got " . gettype($value));
        }

        /** @var JsonSchema $schema */
        $schema = new $this->schemaClass();
        return JsonParser::parse($value, $schema);
    }
}
