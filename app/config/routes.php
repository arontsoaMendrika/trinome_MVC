<?php

use app\controllers\AdminController;
use app\controllers\ApiExampleController;
use app\controllers\AuthController;
use app\controllers\ObjetsController;
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

// =============================================
// Routes Admin (Backoffice)
// =============================================
$router->get('/admin/login', [AdminController::class, 'showLogin']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->get('/admin/logout', [AdminController::class, 'logout']);
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/categories', [AdminController::class, 'getCategories']);
$router->post('/admin/categories/add', [AdminController::class, 'addCategory']);
$router->post('/admin/categories/update', [AdminController::class, 'updateCategory']);
$router->get('/admin/categories/delete/@id:[0-9]+', [AdminController::class, 'deleteCategory']);
$router->get('/admin/statistics', [AdminController::class, 'statistics']);

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

	// Route pour la liste des objets
	$router->get('/objets', [ObjetsController::class, 'index']);

	// API Examples (keep for reference)
	$router->group('/api', function() use ($router) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]', [ ApiExampleController::class, 'updateUser' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]);





