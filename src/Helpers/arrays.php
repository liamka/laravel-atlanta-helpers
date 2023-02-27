<?php

use Illuminate\Support\Arr;

if (!function_exists('json_to_array')) {
    function json_to_array($json, $returnArray = true)
    {
        return json_decode((string) $json, $returnArray);
    }
}

if (!function_exists('json_to_array')) {
    function array_to_json($array = [], $options = []): bool|string
    {
        $default = [\JSON_UNESCAPED_UNICODE];
        $options = Arr::wrap($options);

        $options = array_replace_recursive(array_flip($default), array_flip($options));

        $sum = 0;
        array_walk($options, function ($item, $key) use (&$sum): void {
            $sum = $key + $sum;
        });

        return json_encode($array, $sum);
    }
}
