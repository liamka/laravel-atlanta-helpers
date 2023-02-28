<?php

use Illuminate\Support\Arr;

if (!function_exists('jsonToArray')) {
    function jsonToArray($json, $returnArray = true)
    {
        return json_decode((string)$json, $returnArray);
    }
}

if (!function_exists('arrayToJson')) {
    function arrayToJson($array = [], $options = []): bool|string
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

if (!function_exists('randomFromArray')) {
    function randomFromArray($array = [])
    {
        return $array[array_rand($array)];
    }
}

if (!function_exists('objectToArray')) {
    function objectToArray($obj)
    {
        if (\is_object($obj) || \is_array($obj)) {
            $ret = (array)$obj;
            foreach ($ret as &$singleRet) {
                $singleRet = objectToArray($singleRet);
            }

            return $ret;
        }

        return $obj;
    }
}

if (!\function_exists('arrayDiffAssocRecursive')) {
    function arrayDiffAssocRecursive($array1, $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (\is_array($value)) {
                if (!isset($array2[$key]) || !\is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = arrayDiffAssocRecursive($value, $array2[$key]);
                    if (!empty($new_diff)) {
                        $difference[$key] = $new_diff;
                    }
                }
            } elseif (!\array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }
}