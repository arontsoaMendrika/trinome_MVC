<?php

use app\controllers\ApiExampleController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	// Page d'accueil
	$router->get('/', function() use ($app) {
		$app->render('welcome', [ 'message' => 'Bienvenue sur Takalo - La plateforme de troc à Madagascar!' ]);
	});

	// ===== ROUTES AUTHENTIFICATION =====
	
	// Inscription
	$router->get('/register', [ AuthController::class, 'showRegister' ]);
	$router->post('/register', [ AuthController::class, 'register' ]);
	
	// Connexion
	$router->get('/login', [ AuthController::class, 'showLogin' ]);
	$router->post('/login', [ AuthController::class, 'login' ]);
	
	// Déconnexion
	$router->get('/logout', [ AuthController::class, 'logout' ]);

	// ===== ROUTES GESTION DES PRODUITS (OBJETS) =====
	
	// Liste des produits de l'utilisateur
	$router->get('/mes-produits', [ ProduitController::class, 'index' ]);
	
	// Ajouter un produit
	$router->get('/mes-produits/ajouter', [ ProduitController::class, 'create' ]);
	$router->post('/mes-produits/ajouter', [ ProduitController::class, 'store' ]);
	
	// Modifier un produit
	$router->get('/mes-produits/modifier/@id:[0-9]+', [ ProduitController::class, 'edit' ]);
	$router->post('/mes-produits/modifier/@id:[0-9]+', [ ProduitController::class, 'update' ]);
	
	// Supprimer un produit
	$router->post('/mes-produits/supprimer/@id:[0-9]+', [ ProduitController::class, 'delete' ]);

	// ===== ROUTES API (existantes) =====
	
	$router->get('/hello-world/@name', function($name) {
		echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
	});

	$router->group('/api', function() use ($router) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]', [ ApiExampleController::class, 'updateUser' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]);