<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map(Router $router)
    {
        $router->group(
            [
                'middleware' => 'web',
                'namespace' => $this->namespace,
            ],
            function () {
                require base_path('routes/web.php');
            }
        );

        $router->group(
            [
                'prefix' => 'api/v1',
                'middleware' => 'api',
                'namespace' => $this->namespace . '\\Api',
            ],
            function () {
                require base_path('routes/api.php');
            }
        );
    }
}
