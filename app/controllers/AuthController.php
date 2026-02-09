<?php

namespace app\controllers;

use app\models\User;
use flight\Engine;

class AuthController {

    protected Engine $app;

    public function __construct(Engine $app) {
        $this->app = $app;
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegister(): void {
        $this->app->render('auth/register', [
            'title' => 'Inscription - Takalo',
            'error' => null
        ]);
    }

    /**
     * Traiter l'inscription
     */
    public function register(): void {
        $nom = trim($this->app->request()->data->nom ?? '');
        $email = trim($this->app->request()->data->email ?? '');
        $motdepasse = $this->app->request()->data->motdepasse ?? '';
        $confirm_motdepasse = $this->app->request()->data->confirm_motdepasse ?? '';

        // Validation
        $errors = [];
        
        if (empty($nom)) {
            $errors[] = "Le nom est requis.";
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Un email valide est requis.";
        }
        
        if (strlen($motdepasse) < 6) {
            $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
        }
        
        if ($motdepasse !== $confirm_motdepasse) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        }

        $userModel = new User($this->app->db());
        
        if ($userModel->emailExists($email)) {
            $errors[] = "Cet email est déjà utilisé.";
        }

        if (!empty($errors)) {
            $this->app->render('auth/register', [
                'title' => 'Inscription - Takalo',
                'error' => implode('<br>', $errors),
                'old' => ['nom' => $nom, 'email' => $email]
            ]);
            return;
        }

        // Créer l'utilisateur
        if ($userModel->create($nom, $email, $motdepasse)) {
            // Connecter automatiquement après inscription
            $user = $userModel->findByEmail($email);
            $this->startSession($user);
            $this->app->redirect('/mes-produits');
        } else {
            $this->app->render('auth/register', [
                'title' => 'Inscription - Takalo',
                'error' => "Erreur lors de l'inscription. Veuillez réessayer.",
                'old' => ['nom' => $nom, 'email' => $email]
            ]);
        }
    }

    /**
     * Afficher le formulaire de connexion
     */
    public function showLogin(): void {
        $this->app->render('auth/login', [
            'title' => 'Connexion - Takalo',
            'error' => null
        ]);
    }

    /**
     * Traiter la connexion
     */
    public function login(): void {
        $email = trim($this->app->request()->data->email ?? '');
        $motdepasse = $this->app->request()->data->motdepasse ?? '';

        if (empty($email) || empty($motdepasse)) {
            $this->app->render('auth/login', [
                'title' => 'Connexion - Takalo',
                'error' => 'Email et mot de passe requis.',
                'old' => ['email' => $email]
            ]);
            return;
        }

        $userModel = new User($this->app->db());
        $user = $userModel->findByEmail($email);

        if (!$user || !$userModel->verifyPassword($motdepasse, $user['motdepasse'])) {
            $this->app->render('auth/login', [
                'title' => 'Connexion - Takalo',
                'error' => 'Email ou mot de passe incorrect.',
                'old' => ['email' => $email]
            ]);
            return;
        }

        $this->startSession($user);
        $this->app->redirect('/mes-produits');
    }

    /**
     * Déconnexion
     */
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_unset();
        session_destroy();
        
        $this->app->redirect('/login');
    }

    /**
     * Démarrer la session utilisateur
     */
    private function startSession(array $user): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['logged_in'] = true;
    }
}
