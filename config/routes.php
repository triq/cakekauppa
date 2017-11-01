<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;


Router::defaultRouteClass(DashedRoute::class);

Router::scope('/products', 
    ['controller' => 'Products'],
    function ($routes) {
        $routes->connect('/view/:id', ['action' => 'view']);
        $routes->connect('/view/*', ['action' => 'view']);
        $routes->connect('/index/*', ['action' => 'index']);
});

Router::scope('/cart',
    ['controller' => 'Cart'],
    function ($routes) {
        $routes->connect('/add', ['action' => 'add']);
        $routes->connect('/view', ['action' => 'view']);
});

Router::scope('/admin', 
    ['controller' => 'Admins'],
    function ($routes) {
        $routes->connect('/*', ['action' => 'login']);
});

Router::connect('/', array('controller' => 'products', 'action' => 'index'));

/*
Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    /*
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    */
/*
    $routes->fallbacks(DashedRoute::class);
});
*/

Plugin::routes();
