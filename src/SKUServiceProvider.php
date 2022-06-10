<?php

namespace TONYLABS\SKU;

use Illuminate\Support\Str;
use TONYLABS\SKU\Concerns\Macro;
use TONYLABS\SKU\Concerns\Configurations;
use TONYLABS\SKU\Contracts\Reactor;
use Illuminate\Support\ServiceProvider;


class SKUServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bindReactor();
        $this->bindConfigurations();
        Str::mixin(new Macro);
    }

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function bindReactor()
    {
        $this->app->bind(Reactor::class, function ($app, array $paramters) {
            $generator = $app['config']->get('laravel-sku.generator');
            return new $generator(head($paramters));
        });
    }

    protected function bindConfigurations()
    {
        $this->app->bind(
            Configurations::class,
            function ($app) {
                return new Configurations($app['config']->get('laravel-sku.default', []));
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Reactor::class,
            Configurations::class,
        ];
    }
}