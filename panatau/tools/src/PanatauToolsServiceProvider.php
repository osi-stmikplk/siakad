<?php namespace Panatau\Tools;
/**
 * Service provider untuk tools
 * User: toni
 * Date: 16/11/15
 * Time: 21:02
 */
class PanatauToolsServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        require_once __DIR__ .'/function_helpers.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}