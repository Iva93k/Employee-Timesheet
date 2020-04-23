<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

/*
    Router::scope('/', function (RouteBuilder $routes) {
        // Register scoped middleware for in scopes.
        $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
            'httpOnly' => true
        ]));

        $routes->applyMiddleware('csrf');
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

        $routes->fallbacks(DashedRoute::class);
    });
*/


/*

Router::prefix('admin', function ($routes) {
    // All routes here will be prefixed with `/admin`
    // And have the prefix => admin route element added.
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);

    $routes->fallbacks(DashedRoute::class);
});

Router::prefix('api', function ($routes) {
    // All routes here will be prefixed with `/api`
    // And have the prefix => api route element added.
    $routes->connect('/', ['controller' => 'General', 'action' => 'index']);

    $routes->fallbacks(DashedRoute::class);
});

//Router::extensions(['json', 'xml']);

*/
Router::prefix('admin', function ($routes) {
    // All routes here will be prefixed with `/admin`
    // And have the prefix => admin route element added.
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
    $routes->connect('/company', ['controller' => 'Companies', 'action' => 'view']);
    $routes->connect('/company/update', ['controller' => 'Companies', 'action' => 'edit']);
    $routes->connect('/company/create', ['controller' => 'Companies', 'action' => 'add']);
    $routes->fallbacks(DashedRoute::class);
});

Router::prefix('api', function ($routes) {
    $routes->setExtensions(['json']);
    $routes->resources('Employees');
    $routes->resources('Companies');
    // All routes here will be prefixed with `/api`
    // And have the prefix => api route element added.
    $routes->connect('/', ['controller' => 'Companies', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

Router::scope('/', function ($routes) {
    $routes->connect('/', ['controller' => 'Homepage', 'action' => 'home']);
});


