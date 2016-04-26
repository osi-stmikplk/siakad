<?php
namespace Panatau\Todos;
/**
 * TODOs Service provider
 * User: toni
 * Date: 19/11/15
 * Time: 9:03
 */
class TodosServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $defer = true;

    public function boot()
    {
        // load views supaya bisa mengakses view milik panatau dengan pattern awal todos
        $this->loadViewsFrom(__DIR__.'/resources/views/', 'panatau-todos');
        // setup routes
        if(!$this->app->routesAreCached())
        {
            $this->registerRouter($this->app->router);
        }
        // todos config
        $this->publishes([
            __DIR__.'/config/todos.php' => config_path('todos.php'),
        ], 'config');
        // views publish
        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/panatau/todos')
        ], 'views');
        // global variable di view ..
        $publicAssetPath = 'vendor/panatau/todos';
        view()->share('panatauPublicPath', $publicAssetPath);
        // harus di publish dahulu!
        // ./artisan vendor:publish --provider="Panatau\Todos\TodosServiceProvider" --tag="public" --force
        $this->publishes([
            __DIR__ .'/resources/public' => public_path($publicAssetPath)
        ], 'public');
        // ./artisan vendor:publish --provider="Panatau\Todos\TodosServiceProvider" --tag="migrations" --force
        $this->publishes([
            __DIR__ .'/../migrations' => base_path('database/migrations')
        ], 'migrations');
    }

    /**
     * Register Router untuk package ini!
     * @param \Illuminate\Routing\Router $router
     */
    protected function registerRouter(\Illuminate\Routing\Router $router)
    {
        $router->group(['namespace'=>'Panatau\Todos\Http\Controllers'], function($router) {
            require __DIR__ .'/Http/routes.php';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // config
        $configPath = __DIR__ .'/config/todos.php';
        // lakukan setting biar bisa mengakses config dengan tambahan panatau-todos dibagian depan!
        $this->mergeConfigFrom($configPath, 'panatau-todos');

    }
}