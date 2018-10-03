<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    $routes->fallbacks(DashedRoute::class);
});


Router::scope('/api/v1', ['prefix' => 'api/v1'], function ($routes){
    $routes->setExtensions(['json', 'xml']);
    $routes->resources('Users', [
        'map' => [
            'login' => [
                'action' => 'login',
                'method' => 'POST'
            ]
        ]
    ]);

    $routes->fallbacks('InflectedRoute');
});