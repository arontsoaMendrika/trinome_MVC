<?php

namespace app\middlewares;

use flight\Engine;

class AuthMiddleware {
    protected Engine $app;

    public function __construct(Engine $app) {
        $this->app = $app;
    }

    /**
     * Vérifier que l'utilisateur est connecté avant d'accéder aux routes protégées
     */
    public function before(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->app->redirect('/login');
            exit;
        }
    }
}
