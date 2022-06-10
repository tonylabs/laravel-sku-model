<?php

namespace TONYLABS\SKU\Exceptions;

use Exception;

class SKUException extends Exception
{
    public static function invalidArgument(string $message): self
    {
        return new static($message);
    }

    public function render($request)
    {
        return response(['error' => $this->getMessage()], $this->getCode());
    }
}
