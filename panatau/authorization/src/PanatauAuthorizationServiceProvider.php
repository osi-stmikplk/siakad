<?php namespace Panatau\Authorization;
/**
 * Service provider untuk tools
 * User: toni
 * Date: 16/11/15
 * Time: 21:02
 */
class PanatauAuthorizationServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // register authorization
        $this->app->singleton('Panatau\Authorization\AuthorizationInterface', function($app) {
            return new Authorization();
        });
    }
}