<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return cache()->rememberForever('setting.' . $key, function () use ($key, $default) {
            return DB::table('settings')->where('key', $key)->value('value') ?? $default;
        });
    }
}
