<?php

namespace app\controllers;

use flight\Engine;

class ObjetsController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function index() {
        try {
            $objets = [['id' => 1, 'titre' => 'Test', 'description' => 'Desc']];
            $content = $this->app->render('objets', ['objets' => $objets], false);
            $this->app->render('layout', ['content' => $content, 'title' => 'Objets', 'nonce' => $this->app->get('csp_nonce')]);
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

}