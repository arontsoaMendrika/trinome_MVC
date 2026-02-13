<?php

use app\controllers\ObjetsController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {
    $router->get('/objets', [ObjetsController::class, 'index']);
});





