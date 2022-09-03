<?php

use Illuminate\Contracts\Auth\Authenticatable;

if (! function_exists('photoToMedia')) {
    function photoToMedia(?string $path): ?string
    {
        return $path ? config('app.url') . '/storage/' . $path : null;
    }
}

if (! function_exists('getAuthUser')) {
    function getAuthUser(): ?Authenticatable
    {
        return auth()->guard('api')->user();
    }
}
