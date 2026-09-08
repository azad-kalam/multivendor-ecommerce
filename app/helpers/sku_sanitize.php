<?php

use Illuminate\Support\Str;

if (!function_exists('sanitize_sku')) {

    function sanitize_sku(
        ?string $newSku,
        ?string $oldSku,
        string $productName,
        string $brandName,
        string $colorName,
        string $sizeName
    ): string {

        $newSku = strtoupper(trim((string) $newSku));

        // SKU empty
        if ($newSku === '') {

            $base = implode('-', [
                Str::upper(Str::substr($productName, 0, 3)),
                Str::upper(Str::substr($brandName, 0, 3)),
                Str::upper(Str::substr($colorName, 0, 3)),
                Str::upper(Str::substr($sizeName, 0, 3)),
            ]);

            return $base . '-' . Str::upper(Str::random(6));
        }

        // যদি শেষে already random 6 char থাকে
        if (preg_match('/-[A-Z0-9]{6}$/', $newSku)) {
            return $newSku;
        }

        // না থাকলে add করে দাও
        return $newSku . '-' . Str::upper(Str::random(6));
    }
}
