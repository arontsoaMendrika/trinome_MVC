<?php

use app\controllers\ApiExampleController;
use app\controllers\AuthController;
use app\controllers\ProduitController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	// Page d'accueil - redirection vers login ou mes-objets
	$router->get('/', function() use ($app) {
		if (isset($_SESSION['user_id'])) {
			Flight::redirect('/mes-objets');
		} else {
			$app->render('accueil');
		}
	});

	// Routes d'authentification
	$router->get('/login', [ AuthController::class, 'showLogin' ]);
	$router->post('/login', [ AuthController::class, 'login' ]);
	$router->get('/inscription', [ AuthController::class, 'showRegister' ]);
	$router->post('/inscription', [ AuthController::class, 'register' ]);
	$router->get('/logout', [ AuthController::class, 'logout' ]);

	// Routes des produits
	$router->get('/mes-objets', [ ProduitController::class, 'mesObjets' ]);
	$router->get('/catalogue', [ ProduitController::class, 'catalogue' ]);
	$router->post('/produits/ajouter', [ ProduitController::class, 'ajouter' ]);
	$router->post('/produits/modifier', [ ProduitController::class, 'modifier' ]);
	$router->get('/produits/supprimer/@id:[0-9]+', [ ProduitController::class, 'supprimer' ]);

	// API Examples (keep for reference)
	$router->group('/api', function() use ($router) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]', [ ApiExampleController::class, 'updateUser' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]);