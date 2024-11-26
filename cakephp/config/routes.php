<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

$routes->prefix('Api', function (RouteBuilder $builder) {
    $builder->setExtensions(['json']);
    $builder->setRouteClass(DashedRoute::class);

    // Các route cho API
    $builder->connect('/users', ['controller' => 'Users', 'action' => 'index', '_method' => 'GET']);
    $builder->connect('/users', ['controller' => 'Users', 'action' => 'add', '_method' => 'POST']);
});
