<?php

namespace TONYLABS\SKU\Concerns;

use Closure;
use Illuminate\Support\Str;

class Macro
{
    public function sku(): Closure
    {
        return function ($source, $separator = null) {
            $separator = $separator ?: '-';
            $source = Str::studly($source);
            $source = Str::limit($source, 3, '');
            $signature = str_shuffle(str_repeat(str_pad('0123456789', 8, rand(0, 9).rand(0, 9), STR_PAD_LEFT), 2));
            $signature = substr($signature, 0, 8);
            $sku = implode($separator, [$source, $signature]);
            return Str::upper($sku);
        };
    }
}
