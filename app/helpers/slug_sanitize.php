<?php

use Illuminate\Support\Str;

if (!function_exists('sanitize_slug')) {

    function sanitize_slug(string $source): string
    {
        $slug = Str::slug(trim($source));

        if ($slug === '') {
            $slug = strtolower(Str::random(9));
        }

        // যদি আগেই শেষে 9 character suffix থাকে
        if (preg_match('/-[a-z0-9]{9}$/', $slug)) {
            return $slug;
        }

        // না থাকলে নতুন suffix যোগ করবে
        return $slug . '-' . strtolower(Str::random(9));
    }
}
