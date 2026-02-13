<?php

namespace app\controllers;

use app\models\User;
use Flight;

class AuthController {
    
    private function getUserModel() {
        return new User(Flight::app()->db());
    }
    
    /**
     * Afficher la page de login
     */
    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            Flight::redirect('/mes-objets');
            return;
        }
        Flight::render('auth/login', [
            'title' => 'Connexion - E-Takalo'
        ]);
    }
    
    /**
     * Afficher la page d'inscription
     */
    public function showRegister() {
        if (isset($_SESSION['user_id'])) {
            Flight::redirect('/mes-objets');
            return;
        }
        Flight::render('auth/register', [
            'title' => 'Inscription - E-Takalo'
        ]);
    }
    
    /**
     * Traiter l'inscription
     */
    public function register() {
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';
        $motdepasse = $_POST['motdepasse'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation
        if (empty($nom) || empty($email) || empty($motdepasse)) {
            $_SESSION['error'] = 'Tous les champs sont obligatoires';
            Flight::redirect('/inscription');
            return;
        }
        
        if ($motdepasse !== $confirm_password) {
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
            Flight::redirect('/inscription');
            return;
        }
        
        if (strlen($motdepasse) < 6) {
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins 6 caractères';
            Flight::redirect('/inscription');
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide';
            Flight::redirect('/inscription');
            return;
        }
        
        $userModel = $this->getUserModel();
        
        if ($userModel->emailExists($email)) {
            $_SESSION['error'] = 'Cet email est déjà utilisé';
            Flight::redirect('/inscription');
            return;
        }
        
        // Créer l'utilisateur
        if ($userModel->create($nom, $email, $motdepasse)) {
            $_SESSION['success'] = 'Inscription réussie ! Vous pouvez maintenant vous connecter';
            Flight::redirect('/login');
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'inscription';
            Flight::redirect('/inscription');
        }
    }
    
    /**
     * Traiter la connexion
     */
    public function login() {
        $email = $_POST['email'] ?? '';
        $motdepasse = $_POST['motdepasse'] ?? '';
        
        if (empty($email) || empty($motdepasse)) {
            $_SESSION['error'] = 'Email et mot de passe requis';
            Flight::redirect('/login');
            return;
        }
        
        $user = $this->getUserModel()->authenticate($email, $motdepasse);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['success'] = 'Bienvenue ' . $user['nom'] . ' !';
            Flight::redirect('/mes-objets');
        } else {
            $_SESSION['error'] = 'Email ou mot de passe incorrect';
            Flight::redirect('/login');
        }
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        Flight::redirect('/login');
    }
}
