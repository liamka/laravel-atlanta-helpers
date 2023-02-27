<?php

if (!function_exists('readDuration')) {
    function readDuration(string $content = null): int
    {
        $totalWords = str_word_count(implode(' ', explode(' ', $content)));
        $minutesToRead = round($totalWords / 150);

        return (int)max(1, $minutesToRead);
    }
}
