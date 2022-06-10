<?php

namespace TONYLABS\SKU\Concerns;

use TONYLABS\SKU\Contracts\Reactor as ReactorContract;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;

class Reactor implements Jsonable, Renderable, ReactorContract
{
    protected Model $model;
    protected $configurations;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->configurations = $model->configurations();
    }

    public function render(): string
    {
        $source = $this->getSourceString();
        return $this->generate($source, $this->options->separator, $this->options->unique);
    }

    protected function getSourceString(): string
    {
        $source = $this->configurations->source;
        $fields = array_filter($this->model->only($source));
        return implode($this->configurations->separator, $fields);
    }

    protected function generate(string $source, string $separator, bool $unique = false): string
    {
        $sku = Str::sku($source, $separator);
        if ($unique and $this->exists($sku)) {
            return $this->generate($source, $unique);
        }
        return $sku;
    }

    protected function exists(string $sku): bool
    {
        return $this->model->whereKeyNot($this->model->getKey())->where($this->options->field, $sku)->withoutGlobalScopes()->exists();
    }

    public function __toString()
    {
        return $this->render();
    }

    public function toJson($options = 0)
    {
        return $this->render();
    }
}
