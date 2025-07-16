<?php

namespace Heliostat\SafeJson\Schema;

interface SchemaNode
{
    public function isRequired(): bool;
    public function getDefault(): mixed;
    public function validate(mixed $value): mixed;
}
