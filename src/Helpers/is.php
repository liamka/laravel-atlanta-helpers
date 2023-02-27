<?php

if (!function_exists('isClean')) {
    function isClean($value): bool
    {
        if(null === $value) {
            return true;
        }

        if (is_object($value)) {
            return false;
        }

        if(($value === 0)) {
            return false;
        }

        return (empty($value) && $value === 1) || empty($value);
    }
}

if (!function_exists('isTrue')) {
    function isTrue($bool): bool
    {
        $status = true;
        $type = gettype($bool);
        switch ($type) {
            case 'array':
                foreach ($bool as $key => $value) {
                    $bool[$key] = isTrue($value);
                }

                break;
            case 'integer':
                $status = $bool === 1;

                break;
            case 'string':
                $status = $bool === '1';

                break;
            default:
                $status = $bool === true;

                break;
        }

        return $status;
    }
}

if (!function_exists('isCli')) {
    function isCli(): bool
    {
        return \PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg';
    }
}

if (!function_exists('isJson')) {
    function isJson($contents): bool
    {
        return is_string($contents) && is_array(json_decode($contents, true)) && (json_last_error() === \JSON_ERROR_NONE);
    }
}

if (!\function_exists('isUrl')) {
    function isUrl($value): bool
    {
        return filter_var($value, \FILTER_VALIDATE_URL) !== false;
    }
}
