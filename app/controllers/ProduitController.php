<?php

namespace app\controllers;

use app\models\Produit;
use Flight;

class ProduitController {
    
    private function getProduitModel() {
        return new Produit(Flight::app()->db());
    }
    
    /**
     * Vérifier si l'utilisateur est connecté
     */
    private function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return false;
        }
        return true;
    }
    
    /**
     * Afficher la liste des objets de l'utilisateur
     */
    public function mesObjets() {
        if (!$this->checkAuth()) return;
        
        $model = $this->getProduitModel();
        $produits = $model->findByUserId($_SESSION['user_id']);
        $categories = $model->getCategories();
        
        Flight::render('produits/mes-objets', [
            'title' => 'Mes objets - E-Takalo',
            'produits' => $produits,
            'categories' => $categories,
            'user_nom' => $_SESSION['user_nom']
        ]);
    }
    
    /**
     * Afficher tous les objets disponibles à l'échange
     */
    public function catalogue() {
        if (!$this->checkAuth()) return;
        
        $produits = $this->getProduitModel()->findAllExcept($_SESSION['user_id']);
        
        Flight::render('produits/catalogue', [
            'title' => 'Catalogue - E-Takalo',
            'produits' => $produits,
            'user_nom' => $_SESSION['user_nom']
        ]);
    }
    
    /**
     * Ajouter un nouveau produit
     */
    public function ajouter() {
        if (!$this->checkAuth()) return;
        
        $nom = $_POST['nom'] ?? '';
        $description = $_POST['description'] ?? '';
        $prix = $_POST['prix'] ?? 0;
        $categorie_id = $_POST['categorie_id'] ?? null;
        
        // Validation
        if (empty($nom) || empty($description)) {
            $_SESSION['error'] = 'Le nom et la description sont obligatoires';
            Flight::redirect('/mes-objets');
            return;
        }
        
        // Gestion de l'upload de photo
        $photo = 'default.jpg';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $photo;
            
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                $photo = 'default.jpg';
            }
        }
        
        if ($this->getProduitModel()->create($nom, $description, $prix, $photo, $categorie_id, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Objet ajouté avec succès !';
        } else {
            $_SESSION['error'] = 'Erreur lors de l\'ajout de l\'objet';
        }
        
        Flight::redirect('/mes-objets');
    }
    
    /**
     * Modifier un produit
     */
    public function modifier() {
        if (!$this->checkAuth()) return;
        
        $id = $_POST['id'] ?? null;
        $nom = $_POST['nom'] ?? '';
        $description = $_POST['description'] ?? '';
        $prix = $_POST['prix'] ?? 0;
        $categorie_id = $_POST['categorie_id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'ID du produit manquant';
            Flight::redirect('/mes-objets');
            return;
        }
        
        // Vérifier que le produit appartient à l'utilisateur
        $model = $this->getProduitModel();
        $produit = $model->findById($id);
        if (!$produit || $produit['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Produit introuvable';
            Flight::redirect('/mes-objets');
            return;
        }
        
        // Gestion de l'upload de photo
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $photo;
            
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                $photo = null;
            }
        }
        
        if ($model->update($id, $nom, $description, $prix, $photo, $categorie_id)) {
            $_SESSION['success'] = 'Objet modifié avec succès !';
        } else {
            $_SESSION['error'] = 'Erreur lors de la modification';
        }
        
        Flight::redirect('/mes-objets');
    }
    
    /**
     * Supprimer un produit
     */
    public function supprimer($id) {
        if (!$this->checkAuth()) return;
        
        if ($this->getProduitModel()->delete($id, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Objet supprimé avec succès !';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        
        Flight::redirect('/mes-objets');
    }
}
