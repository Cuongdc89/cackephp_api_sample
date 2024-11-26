<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

return static function (Cake\Routing\RouteBuilder $routes) {
    // Set default route class
    $routes->setRouteClass(DashedRoute::class);

    // Default route for the homepage
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    $routes->prefix('Api', function (\Cake\Routing\RouteBuilder $builder) {
        $builder->setExtensions(['json']);
        $builder->setRouteClass(DashedRoute::class);

        // Các route cho API
        $builder->connect('/users', ['controller' => 'Users', 'action' => 'index', '_method' => 'GET']);
        $builder->connect('/users', ['controller' => 'Users', 'action' => 'add', '_method' => 'POST']);
    });
    /*
     * Connect catchall routes for all controllers.
     * By default, all controllers are accessible under `/controller/action`.
     */
    $routes->fallbacks(DashedRoute::class);
};
