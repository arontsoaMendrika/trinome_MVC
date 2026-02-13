<?php

namespace app\controllers;

use flight\Engine;
use Flight;

class AdminController {

	protected Engine $app;

	// Identifiants admin par défaut
	const ADMIN_EMAIL = 'admin@takalo.com';
	const ADMIN_PASSWORD = 'admin123';

	public function __construct($app) {
		$this->app = $app;
	}

	/**
	 * Vérifier si l'admin est connecté
	 */
	private function requireAdmin() {
		if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
			Flight::redirect('/admin/login');
			return false;
		}
		return true;
	}

	/**
	 * Afficher le formulaire de login admin (avec identifiants par défaut pré-remplis)
	 */
	public function showLogin() {
		if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
			Flight::redirect('/admin');
			return;
		}
		$this->app->render('admin/login', [
			'default_email' => self::ADMIN_EMAIL,
			'default_password' => self::ADMIN_PASSWORD,
		]);
	}

	/**
	 * Traiter le login admin
	 */
	public function login() {
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';

		if ($email === self::ADMIN_EMAIL && $password === self::ADMIN_PASSWORD) {
			$_SESSION['admin_logged_in'] = true;
			$_SESSION['admin_email'] = $email;
			Flight::redirect('/admin');
		} else {
			$_SESSION['admin_error'] = 'Identifiants incorrects';
			Flight::redirect('/admin/login');
		}
	}

	/**
	 * Déconnexion admin
	 */
	public function logout() {
		unset($_SESSION['admin_logged_in']);
		unset($_SESSION['admin_email']);
		Flight::redirect('/admin/login');
	}

	/**
	 * Dashboard admin avec statistiques
	 */
	public function dashboard() {
		if (!$this->requireAdmin()) return;

		$nbUsers = $this->app->db()->fetchField("SELECT COUNT(*) FROM users");
		$nbEchanges = $this->app->db()->fetchField("SELECT COUNT(*) FROM historique");
		$nbCategories = $this->app->db()->fetchField("SELECT COUNT(*) FROM categorie");
		$nbProduits = $this->app->db()->fetchField("SELECT COUNT(*) FROM produits");

		$this->app->render('admin/dashboard', [
			'nbUsers' => $nbUsers,
			'nbEchanges' => $nbEchanges,
			'nbCategories' => $nbCategories,
			'nbProduits' => $nbProduits,
		]);
	}

	// =============================================
	// GESTION DES CATÉGORIES (CRUD)
	// =============================================

	/**
	 * Liste des catégories
	 */
	public function getCategories() {
		if (!$this->requireAdmin()) return;

		$categories = $this->app->db()->fetchAll("SELECT * FROM categorie ORDER BY id DESC");
		$this->app->render('admin/categories', ['categories' => $categories]);
	}

	/**
	 * Ajouter une catégorie
	 */
	public function addCategory() {
		if (!$this->requireAdmin()) return;

		$nom = trim($_POST['nom'] ?? '');
		if (empty($nom)) {
			$_SESSION['admin_error'] = 'Le nom de la catégorie est obligatoire';
			Flight::redirect('/admin/categories');
			return;
		}

		$exists = $this->app->db()->fetchField("SELECT COUNT(*) FROM categorie WHERE nom = ?", [$nom]);
		if ($exists > 0) {
			$_SESSION['admin_error'] = 'Cette catégorie existe déjà';
			Flight::redirect('/admin/categories');
			return;
		}

		$this->app->db()->runQuery("INSERT INTO categorie (nom) VALUES (?)", [$nom]);
		$_SESSION['admin_success'] = 'Catégorie ajoutée avec succès';
		Flight::redirect('/admin/categories');
	}

	/**
	 * Modifier une catégorie
	 */
	public function updateCategory() {
		if (!$this->requireAdmin()) return;

		$id = (int)($_POST['id'] ?? 0);
		$nom = trim($_POST['nom'] ?? '');

		if (empty($nom) || $id <= 0) {
			$_SESSION['admin_error'] = 'Données invalides';
			Flight::redirect('/admin/categories');
			return;
		}

		$this->app->db()->runQuery("UPDATE categorie SET nom = ? WHERE id = ?", [$nom, $id]);
		$_SESSION['admin_success'] = 'Catégorie modifiée avec succès';
		Flight::redirect('/admin/categories');
	}

	/**
	 * Supprimer une catégorie
	 */
	public function deleteCategory($id) {
		if (!$this->requireAdmin()) return;

		$id = (int)$id;
		if ($id <= 0) {
			$_SESSION['admin_error'] = 'ID invalide';
			Flight::redirect('/admin/categories');
			return;
		}

		$count = $this->app->db()->fetchField("SELECT COUNT(*) FROM produits WHERE categorie_id = ?", [$id]);
		if ($count > 0) {
			$_SESSION['admin_error'] = 'Impossible de supprimer : ' . $count . ' produit(s) utilisent cette catégorie';
			Flight::redirect('/admin/categories');
			return;
		}

		$this->app->db()->runQuery("DELETE FROM categorie WHERE id = ?", [$id]);
		$_SESSION['admin_success'] = 'Catégorie supprimée avec succès';
		Flight::redirect('/admin/categories');
	}

	// =============================================
	// STATISTIQUES
	// =============================================

	/**
	 * Page de statistiques détaillées
	 */
	public function statistics() {
		if (!$this->requireAdmin()) return;

		$nbUsers = $this->app->db()->fetchField("SELECT COUNT(*) FROM users");
		$nbEchanges = $this->app->db()->fetchField("SELECT COUNT(*) FROM historique");
		$nbCategories = $this->app->db()->fetchField("SELECT COUNT(*) FROM categorie");
		$nbProduits = $this->app->db()->fetchField("SELECT COUNT(*) FROM produits");

		$recentUsers = $this->app->db()->fetchAll("SELECT id, nom, email FROM users ORDER BY id DESC LIMIT 5");

		$recentEchanges = $this->app->db()->fetchAll("
			SELECT h.id, h.date_echange, u.nom as user_nom, p.nom as produit_nom, s.nom as status_nom 
			FROM historique h 
			JOIN users u ON h.user_id = u.id 
			JOIN produits p ON h.produit_id = p.id 
			JOIN status_echange s ON h.status_echange_id = s.id 
			ORDER BY h.date_echange DESC LIMIT 5
		");

		$this->app->render('admin/statistics', [
			'nbUsers' => $nbUsers,
			'nbEchanges' => $nbEchanges,
			'nbCategories' => $nbCategories,
			'nbProduits' => $nbProduits,
			'recentUsers' => $recentUsers,
			'recentEchanges' => $recentEchanges,
		]);
	}
}