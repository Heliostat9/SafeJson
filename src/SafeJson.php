<?php

namespace Heliostat\SafeJson;

use Heliostat\SafeJson\Parser\JsonParser;

class SafeJson
{
    public static function parse(string $json, JsonSchema $schema): JsonSchema
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return JsonParser::parse($data, $schema);
    }
}
