<?php

if (!function_exists('readDuration')) {
    function readDuration(string $content = ''): int
    {
        $totalWords = str_word_count(implode(' ', explode(' ', $content)));
        $minutesToRead = round($totalWords / 150);

        return (int)max(1, $minutesToRead);
    }
}

if (!function_exists('minifyHtml')) {
    function minifyHtml(string $content = ''): mixed
    {
        return \preg_replace('#\s+#', ' ', $content);
    }
}


