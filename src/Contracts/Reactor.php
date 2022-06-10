<?php

namespace TONYLABS\SKU\Contracts;

interface Reactor
{
    /**
     * Render the SKU string.
     *
     * @return string
     */
    public function render(): string;
}
