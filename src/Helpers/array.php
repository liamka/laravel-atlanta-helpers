<?php

use Illuminate\Support\Arr;

if (!function_exists('json_to_array')) {
    function json_to_array($json, $returnArray = true)
    {
        return json_decode((string)$json, $returnArray);
    }
}

if (!function_exists('array_to_json')) {
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

if (!function_exists('random_from_array')) {
    function random_from_array($array = [])
    {
        return $array[array_rand($array)];
    }
}

if (!function_exists('object_to_array')) {
    function object_to_array($obj)
    {
        if (\is_object($obj) || \is_array($obj)) {
            $ret = (array)$obj;
            foreach ($ret as &$singleRet) {
                $singleRet = object_to_array($singleRet);
            }

            return $ret;
        }

        return $obj;
    }
}

if (!\function_exists('array_diff_assoc_recursive')) {
    function array_diff_assoc_recursive($array1, $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (\is_array($value)) {
                if (!isset($array2[$key]) || !\is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
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

if (!function_exists('array_to_2d')) {
    function array_to_2d($array = [], $delimiter = '.')
    {
        if (empty($array)) {
            return [];
        }

        $a = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
        $result = [];
        foreach ($a as $singleA) {
            $keys = [];
            foreach (\range(0, $a->getDepth()) as $depth) {
                $keys[] = $a->getSubIterator($depth)->key();
            }

            $primary_key = implode($delimiter, $keys);

            if (is_numeric(substr($primary_key, -1, 1))) {
                $d = $keys;

                array_pop($d);

                $k_ = implode($delimiter, $d);

                if ($k_ !== '') {
                    $result[implode($delimiter, $d)][] = $singleA;
                }
            }

            $result[$primary_key] = $singleA;
        }

        return $result;
    }
}
