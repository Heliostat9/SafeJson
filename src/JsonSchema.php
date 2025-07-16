<?php

namespace Heliostat\SafeJson;

use Heliostat\SafeJson\Schema\BoolSchema;
use Heliostat\SafeJson\Schema\IntSchema;
use Heliostat\SafeJson\Schema\ObjectSchema;
use Heliostat\SafeJson\Schema\StringSchema;

#[\AllowDynamicProperties]
abstract class JsonSchema
{
    abstract public function rules(): array;

    public static function int(): IntSchema
    {
        return new IntSchema();
    }

    public static function string(): StringSchema
    {
        return new StringSchema();
    }

    public static function bool(): BoolSchema
    {
        return new BoolSchema();
    }

    public static function object(string $schemaClass): ObjectSchema
    {
        return new ObjectSchema($schemaClass);
    }
}
