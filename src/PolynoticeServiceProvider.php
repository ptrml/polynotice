<?php
namespace Ptrml\Polycomments;

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
        $this->app['router']->group(['namespace' => 'Ptrml\Polycomments\Controllers','middleware' => ['web']], function () {
            require __DIR__.'/Routes/polycomments_default_routes.php';
        });
    }

    $this->loadViewsFrom(__DIR__.'/Views', 'polycomments');

    $this->publishes([
        __DIR__.'/config/polycomments.php' => config_path('ptrml/polycomments/polycomments.php'),
        __DIR__.'/Views' => resource_path('views/vendor/polycomments'),
        __DIR__.'/Controllers/PolycommentsController.php' => app_path('Http/Controllers/PolycommentsController.php'),//config_path('ptrml/polycomments/PolycommentsController.php'),
        //__DIR__.'/Routes/polycomments_routes.php' => base_path('routes/ptrml/polycomments/polycomments_routes.php'),//config_path('ptrml/polycomments/polycomments_routes.php'),
        
    ], 'polycomments');
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