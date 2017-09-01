<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Waybill;
use App\Manifest;
use App\Observers\WaybillObserver;
use App\Observers\ManifestObserver;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);
        Waybill::observe(new WaybillObserver);
        Manifest::observe(new ManifestObserver);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }
    }

}
