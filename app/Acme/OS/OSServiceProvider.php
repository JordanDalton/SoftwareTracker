<?php namespace Acme\OS;

use Illuminate\Support\ServiceProvider;

class OSServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('windows', function()
        {
            return new \Acme\OS\Windows;
        });
    }
}