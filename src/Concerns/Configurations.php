<?php

namespace TONYLABS\SKU\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use TONYLABS\SKU\Exceptions\SKUException;
use TONYLABS\SKU\Contracts\Configurations as ConfigurationsContract;

class Configurations implements ConfigurationsContract
{
    protected $source;
    protected $field;
    protected $unique;
    protected $separator;
    protected $generateOnCreate;
    protected $generateOnUpdate;

    public function __construct(array $config)
    {
        $this->from($config['source'])
            ->target($config['field'])
            ->using($config['separator'])
            ->forceUnique($config['unique'])
            ->generateOnCreate($config['generate_on_create'])
            ->refreshOnUpdate($config['generate_on_update']);
    }

    public static function make(): ConfigurationsContract
    {
        return resolve(self::class);
    }

    public function from($field): ConfigurationsContract
    {
        $this->source = Arr::wrap($field);
        return $this;
    }

    public function target(string $field): ConfigurationsContract
    {
        $this->field = $field;
        return $this;
    }

    public function forceUnique(bool $value): ConfigurationsContract
    {
        $this->unique = $value;
        return $this;
    }

    public function allowDuplicates(): ConfigurationsContract
    {
        return $this->forceUnique(false);
    }

    public function using(string $separator): ConfigurationsContract
    {
        $this->separator = $separator;
        return $this;
    }

    public function generateOnCreate(bool $value): ConfigurationsContract
    {
        $this->generateOnCreate = $value;
        return $this;
    }

    public function refreshOnUpdate(bool $value): ConfigurationsContract
    {
        $this->generateOnUpdate = $value;
        return $this;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }
        throw SKUException::invalidArgument("`{$property}` does not exist as a option", 500);
    }
}
