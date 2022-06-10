<?php

namespace TONYLABS\SKU;

use TONYLABS\SKU\Concerns\Observer;
use TONYLABS\SKU\Concerns\Configurations;

trait HasSKU
{
    public static function bootHasSKU()
    {
        static::observe(Observer::class);
    }

    public function configurations(): Configurations
    {
        return resolve(Configurations::class);
    }

    public function configuration(string $key)
    {
        return $this->configurations()->{$key};
    }

    public function getSKUAttribute($value): string
    {
        return (string) $value ?: $this->getAttribute($this->configuration('field'));
    }
}
