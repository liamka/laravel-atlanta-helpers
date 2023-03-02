<?php

if (!function_exists('read_duration')) {
    function read_duration(string $content = ''): int
    {
        $totalWords = str_word_count(implode(' ', explode(' ', $content)));
        $minutesToRead = round($totalWords / 150);

        return (int)max(1, $minutesToRead);
    }
}

if (!function_exists('minify_html')) {
    function minify_html(string $content = ''): mixed
    {
        return \preg_replace('#\s+#', ' ', $content);
    }
}


