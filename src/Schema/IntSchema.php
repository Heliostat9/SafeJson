<?php

namespace Heliostat\SafeJson\Schema;

use Heliostat\SafeJson\Exception\ValidationException;

class IntSchema implements SchemaNode
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

    public function validate(mixed $value): int
    {
        if (!is_int($value)) {
            throw new ValidationException("Expected int, got " . gettype($value));
        }
        return $value;
    }
}
