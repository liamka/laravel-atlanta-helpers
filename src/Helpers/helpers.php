<?php

use Illuminate\Support\Arr;

if (!function_exists('display_errors')) {
    function display_errors(int $display = 1): void
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
            echo is_true(is_cli()) ? "\n" : \PHP_EOL;
        }
    }
}

if (!function_exists('random_chars')) {
    function random_chars(int $length = 10, string $type = 'ANY'): string
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

if (!function_exists('random_string')) {
    function random_string(int $length = 10): string
    {
        return random_chars($length, 'chars');
    }
}

if (!function_exists('random_integer')) {
    function random_integer(int $length = 10): int
    {
        return (int)random_chars($length, 'numbers');
    }
}

if (!\function_exists('vk_printf')) {
    function vk_printf($string, $params = [], $hide_if_null_value = false): mixed
    {
        $params = array_to_2d($params);

        $vars = [];
        \preg_match_all('#{{(.*?)}}#s', $string, $matches);
        if (!is_clean($matches[1])) {
            $matches = $matches[1];

            foreach ($matches as $match) {
                $vars[] = [
                    'search' => $match,
                    'replace' => @$params[$match]
                ];
            }
        }

        $params = array_diff_assoc_recursive($vars, $params);

        foreach ($params as $param) {
            if (!\is_null($param['replace']) || $hide_if_null_value === true) {
                $string = \str_replace('{{' . $param['search'] . '}}', $param['replace'], $string);
            }
        }

        return $string;
    }
}

if (!function_exists('vk_preg_match')) {
    function vk_preg_match($string, $pattern): bool
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

if (!\function_exists('e_cli')) {
    function e_cli($string, $foreground_color = 'green', $background_color = null): void
    {
        $foreground_colors = [];
        $background_colors = [];
        if (is_cli() === true) {
            $foreground_color = @strtolower($foreground_color);
            $background_color = @strtolower($background_color);

            $foreground_colors['black'] = '0;30';
            $foreground_colors['dark_gray'] = '1;30';
            $foreground_colors['blue'] = '0;34';
            $foreground_colors['light_blue'] = '1;34';
            $foreground_colors['green'] = '0;32';
            $foreground_colors['light_green'] = '1;32';
            $foreground_colors['cyan'] = '0;36';
            $foreground_colors['light_cyan'] = '1;36';
            $foreground_colors['red'] = '0;31';
            $foreground_colors['light_red'] = '1;31';
            $foreground_colors['purple'] = '0;35';
            $foreground_colors['light_purple'] = '1;35';
            $foreground_colors['brown'] = '0;33';
            $foreground_colors['yellow'] = '1;33';
            $foreground_colors['light_gray'] = '0;37';
            $foreground_colors['white'] = '1;37';

            $background_colors['black'] = '40';
            $background_colors['red'] = '41';
            $background_colors['green'] = '42';
            $background_colors['yellow'] = '43';
            $background_colors['blue'] = '44';
            $background_colors['magenta'] = '45';
            $background_colors['cyan'] = '46';
            $background_colors['light_gray'] = '47';

            $colored_string = '';

            // Check if given foreground color found
            if (isset($foreground_colors[$foreground_color])) {
                $colored_string .= "\033[" . $foreground_colors[$foreground_color] . 'm';
            }

            // Check if given background color found
            if (isset($background_colors[$background_color])) {
                $colored_string .= "\033[" . $background_colors[$background_color] . 'm';
            }

            // Add string and end coloring
            $colored_string .= $string . "\033[0m";

            echo($colored_string . \PHP_EOL);
        }
    }
}
