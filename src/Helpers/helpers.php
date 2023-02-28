<?php

use Illuminate\Support\Arr;

if (!function_exists('displayErrors')) {
    function displayErrors(int $display = 1): void
    {
        ini_set('display_errors', (string)$display);
        ini_set('display_startup_errors', (string)$display);
        error_reporting($display === 1 ? \E_ALL : null);
    }
}

if (!function_exists('nl')) {
    function nl($count = 1): void
    {
        for ($i = 1; $i <= $count; ++$i) {
            echo isTrue(isCli()) ? "\n" : \PHP_EOL;
        }
    }
}

if (!function_exists('randomChars')) {
    function randomChars(int $length = 10, string $type = 'ANY'): string
    {
        $characters = '';

        $type = mb_strtolower($type);

        if ($type === 'numbers') {
            $characters = '0123456789';
        } elseif ($type === 'chars') {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } elseif ($type === 'any') {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } elseif ($type === 'lowercase') {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        } elseif ($type === 'uppercase') {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } elseif ($type === 'str_lowercase') {
            $characters = 'abcdefghijklmnopqrstuvwxyz';
        }

        $charactersLength = mb_strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}

if (!function_exists('randomString')) {
    function randomString(int $length = 10): string
    {
        return randomChars($length, 'chars');
    }
}

if (!function_exists('randomInteger')) {
    function randomInteger(int $length = 10): int
    {
        return (int)randomChars($length, 'numbers');
    }
}

if (!\function_exists('vkSprintF')) {
    function vkSprintF($string, $params = [], $hide_if_null_value = false): mixed
    {
        $vars = [];
        \preg_match_all('#{{(.*?)}}#s', $string, $matches);
        if (!isClean($matches[1])) {
            $matches = $matches[1];

            foreach ($matches as $match) {
                $vars[] = [
                    'search' => $match,
                    'replace' => @$params[$match]
                ];
            }
        }

        $params = arrayDiffAssocRecursive($vars, $params);

        foreach ($params as $param) {
            if (!\is_null($param['replace']) || $hide_if_null_value === true) {
                $string = \str_replace('{{' . $param['search'] . '}}', $param['replace'], $string);
            }
        }

        return $string;
    }
}

if (!function_exists('vkPregMatch')) {
    function vkPregMatch($string, $pattern): bool
    {
        $pattern = str_replace('.', '\.', $pattern);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = str_replace('[num]', '[0-9]+', $pattern);
        $pattern = str_replace('[str]', '[a-zA-Z]*', $pattern);
        $pattern = str_replace('[chars]', '[a-zA-Z]*', $pattern);
        $pattern = str_replace('*', '[a-zA-Z0-9_\-\p{Cyrillic}]+', $pattern);
        $pattern = str_replace('[any]', '[a-zA-Z0-9_\-\p{Cyrillic}]+', $pattern);
        $pattern = "/{$pattern}/u";

        return (bool)preg_match($pattern, $string);
    }
}

if (!function_exists('taps')) {
    function taps(...$arguments): mixed
    {
        $callback = $arguments[array_key_last($arguments)];

        array_pop($arguments);

        $arguments = null === $arguments ? [] : $arguments;

        if (is_object($callback)) {
            return $callback(...$arguments);
        }

        return null;

    }
}
