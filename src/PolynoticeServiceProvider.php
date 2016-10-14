<?php
namespace Ptrml\Polynotice;

use Illuminate\Support\ServiceProvider;

class PolynoticeServiceProvider extends ServiceProvider
{

/**
* Bootstrap any application services.
*
* @return void
*/
public function boot()
{
    $this->loadMigrationsFrom(__DIR__.'/Migrations');

    if (! $this->app->routesAreCached())
    {
        $this->app['router']->group(['namespace' => 'Ptrml\Polynotice\Controllers','middleware' => ['web']], function () {
            require __DIR__.'/Routes/polynotice_routes.php';
        });
    }

    $this->publishes([
        __DIR__.'/../assets/js/components' => resource_path('assets/js/components/polynotice'),

    ], 'polynotice');

    $this->publishes([
        __DIR__ . '/../assets' => public_path('vendor/polynotice'),
    ], 'public');
}

/**
* Register any application services.
*
* @return void
*/
public function register()
{
//
}

}