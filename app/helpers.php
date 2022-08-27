<?php

if (! function_exists('photoToMedia')) {
    function photoToMedia(?string $path): ?string
    {
        return $path ? config('app.url') . '/storage/' . $path : null;
    }
}
