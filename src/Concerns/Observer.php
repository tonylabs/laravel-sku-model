<?php

namespace TONYLABS\SKU\Concerns;

use TONYLABS\SKU\Contracts\Reactor;
use Illuminate\Database\Eloquent\Model;

class Observer
{
    public function creating(Model $model): void
    {
        $field = $model->configuration('field');
        if ($model->configuration('generateOnCreate')) {
            $model->setAttribute($field, (string) $this->generator($model));
        }
    }

    public function updating(Model $model): void
    {
        $field = $model->configuration('field');
        if ($model->isDirty($field)) {
            return;
        }
        $source = $model->configuration('source');
        if ($model->configuration('generateOnUpdate') and $model->isDirty($source)) {
            $model->setAttribute($field, (string) $this->generator($model));
        }
    }

    protected function generator(Model $model): Reactor
    {
        return resolve(Reactor::class, ['model' => $model]);
    }
}
