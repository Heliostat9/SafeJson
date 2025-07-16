<?php

namespace Heliostat\SafeJson\Parser;

use Heliostat\SafeJson\Exception\ValidationException;
use Heliostat\SafeJson\JsonSchema;
use Heliostat\SafeJson\Schema\SchemaNode;

class JsonParser
{
    public static function parse(array $data, JsonSchema $schema): JsonSchema
    {
        $rules = $schema->rules();

        foreach ($rules as $key => $rule) {
            /** @var SchemaNode $rule */
            if (!array_key_exists($key, $data)) {
                if ($rule->isRequired()) {
                    throw new ValidationException("Missing required field: $key");
                }
                $value = $rule->getDefault();
            } else {
                $value = $rule->validate($data[$key]);
            }

            $schema->{$key} = $value;
        }

        return $schema;
    }
}
