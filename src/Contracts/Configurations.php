<?php

namespace TONYLABS\SKU\Contracts;

interface Configurations
{
    public static function make(): self;
    public function from($field): self;
    public function target(string $field): self;
    public function forceUnique(bool $value): self;
    public function allowDuplicates(): self;
    public function using(string $separator): self;
    public function generateOnCreate(bool $value): self;
    public function refreshOnUpdate(bool $value): self;
}
