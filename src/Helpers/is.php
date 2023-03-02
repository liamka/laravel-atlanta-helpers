<?php

if (!function_exists('is_clean')) {
    function is_clean($value): bool
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

if (!function_exists('is_true')) {
    function is_true($bool): bool
    {
        $status = true;
        $type = gettype($bool);
        switch ($type) {
            case 'array':
                foreach ($bool as $key => $value) {
                    $bool[$key] = is_true($value);
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

if (!function_exists('is_cli')) {
    function is_cli(): bool
    {
        return \PHP_SAPI === 'cli' || \PHP_SAPI === 'phpdbg';
    }
}

if (!function_exists('is_json')) {
    function is_json($contents): bool
    {
        return is_string($contents) && is_array(json_decode($contents, true)) && (json_last_error() === \JSON_ERROR_NONE);
    }
}

if (!\function_exists('is_url')) {
    function is_url($value): bool
    {
        return filter_var($value, \FILTER_VALIDATE_URL) !== false;
    }
}

if (!\function_exists('is_html')) {
    function is_html($string): bool
    {
        return is_string($string) && (strlen(strip_tags($string)) < strlen($string));
    }
}
