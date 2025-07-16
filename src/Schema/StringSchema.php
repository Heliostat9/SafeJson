<?php

namespace Heliostat\SafeJson\Schema;

use Heliostat\SafeJson\Exception\ValidationException;

class StringSchema implements SchemaNode
{
    private bool $required = false;
    private mixed $default = null;

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    public function default(mixed $value): self
    {
        $this->default = $value;
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

    public function validate(mixed $value): string
    {
        if (!is_string($value)) {
            throw new ValidationException("Expected string, got " . gettype($value));
        }
        return $value;
    }
}
