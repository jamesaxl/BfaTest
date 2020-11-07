<?php

namespace App\Providers;

use App\Http\DataGrids\Request;
use Illuminate\Support\ServiceProvider;

class DataGridServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('datagrid.request', function () {
            return new Request;
        });
    }
}
