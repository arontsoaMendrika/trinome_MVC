<?php

namespace app\controllers;

use app\models\Produit;
use flight\Engine;

class ProduitController {

    protected Engine $app;

    public function __construct(Engine $app) {
        $this->app = $app;
    }

    /**
     * Vérifier si l'utilisateur est connecté
     */
    private function requireAuth(): ?array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (empty($_SESSION['logged_in']) || empty($_SESSION['user_id'])) {
            $this->app->redirect('/login');
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'nom' => $_SESSION['user_nom'],
            'email' => $_SESSION['user_email']
        ];
    }

    /**
     * Liste des produits de l'utilisateur
     */
    public function index(): void {
        $user = $this->requireAuth();
        if (!$user) return;

        $produitModel = new Produit($this->app->db());
        $produits = $produitModel->getAllByUser($user['id']);

        $this->app->render('produits/index', [
            'title' => 'Mes Objets - Takalo',
            'produits' => $produits,
            'user' => $user,
            'success' => $_SESSION['flash_success'] ?? null
        ]);
        
        unset($_SESSION['flash_success']);
    }

    /**
     * Formulaire de création d'un produit
     */
    public function create(): void {
        $user = $this->requireAuth();
        if (!$user) return;

        $produitModel = new Produit($this->app->db());
        $categories = $produitModel->getAllCategories();

        $this->app->render('produits/create', [
            'title' => 'Ajouter un objet - Takalo',
            'categories' => $categories,
            'user' => $user,
            'error' => null,
            'old' => []
        ]);
    }

    /**
     * Enregistrer un nouveau produit
     */
    public function store(): void {
        $user = $this->requireAuth();
        if (!$user) return;

        $nom = trim($this->app->request()->data->nom ?? '');
        $description = trim($this->app->request()->data->description ?? '');
        $prix = floatval($this->app->request()->data->prix ?? 0);
        $categorie_id = intval($this->app->request()->data->categorie_id ?? 0);

        // Validation
        $errors = [];
        
        if (empty($nom)) {
            $errors[] = "Le titre est requis.";
        }
        
        if (empty($description)) {
            $errors[] = "La description est requise.";
        }
        
        if ($prix <= 0) {
            $errors[] = "Le prix estimatif doit être supérieur à 0.";
        }
        
        if ($categorie_id <= 0) {
            $errors[] = "Veuillez sélectionner une catégorie.";
        }

        // Gestion des photos
        $photos = [];
        $uploadDir = __DIR__ . '/../../public/uploads/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!empty($_FILES['photos']['name'][0])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            foreach ($_FILES['photos']['name'] as $key => $filename) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['photos']['tmp_name'][$key];
                    $fileType = $_FILES['photos']['type'][$key];
                    
                    if (!in_array($fileType, $allowedTypes)) {
                        $errors[] = "Le fichier '$filename' n'est pas une image valide.";
                        continue;
                    }
                    
                    if ($_FILES['photos']['size'][$key] > 5 * 1024 * 1024) { // 5MB max
                        $errors[] = "Le fichier '$filename' est trop volumineux (max 5MB).";
                        continue;
                    }
                    
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $newFilename = uniqid('produit_') . '.' . $extension;
                    
                    if (move_uploaded_file($tmpName, $uploadDir . $newFilename)) {
                        $photos[] = $newFilename;
                    } else {
                        $errors[] = "Erreur lors de l'upload de '$filename'.";
                    }
                }
            }
        }

        if (empty($photos)) {
            $errors[] = "Au moins une photo est requise.";
        }

        if (!empty($errors)) {
            $produitModel = new Produit($this->app->db());
            $categories = $produitModel->getAllCategories();
            
            $this->app->render('produits/create', [
                'title' => 'Ajouter un objet - Takalo',
                'categories' => $categories,
                'user' => $user,
                'error' => implode('<br>', $errors),
                'old' => [
                    'nom' => $nom,
                    'description' => $description,
                    'prix' => $prix,
                    'categorie_id' => $categorie_id
                ]
            ]);
            return;
        }

        // Sauvegarder les photos en JSON (plusieurs photos)
        $photoJson = implode(',', $photos);

        $produitModel = new Produit($this->app->db());
        $result = $produitModel->create([
            'nom' => $nom,
            'description' => $description,
            'prix' => $prix,
            'photo' => $photoJson,
            'categorie_id' => $categorie_id,
            'user_id' => $user['id']
        ]);

        if ($result) {
            $_SESSION['flash_success'] = "Objet ajouté avec succès!";
            $this->app->redirect('/mes-produits');
        } else {
            $categories = $produitModel->getAllCategories();
            $this->app->render('produits/create', [
                'title' => 'Ajouter un objet - Takalo',
                'categories' => $categories,
                'user' => $user,
                'error' => "Erreur lors de l'ajout. Veuillez réessayer.",
                'old' => [
                    'nom' => $nom,
                    'description' => $description,
                    'prix' => $prix,
                    'categorie_id' => $categorie_id
                ]
            ]);
        }
    }

    /**
     * Formulaire de modification d'un produit
     */
    public function edit(int $id): void {
        $user = $this->requireAuth();
        if (!$user) return;

        $produitModel = new Produit($this->app->db());
        $produit = $produitModel->findByIdAndUser($id, $user['id']);

        if (!$produit) {
            $this->app->redirect('/mes-produits');
            return;
        }

        $categories = $produitModel->getAllCategories();

        $this->app->render('produits/edit', [
            'title' => 'Modifier - ' . $produit['nom'],
            'produit' => $produit,
            'categories' => $categories,
            'user' => $user,
            'error' => null
        ]);
    }

    /**
     * Mettre à jour un produit
     */
    public function update(int $id): void {
        $user = $this->requireAuth();
        if (!$user) return;

        $produitModel = new Produit($this->app->db());
        $produit = $produitModel->findByIdAndUser($id, $user['id']);

        if (!$produit) {
            $this->app->redirect('/mes-produits');
            return;
        }

        $nom = trim($this->app->request()->data->nom ?? '');
        $description = trim($this->app->request()->data->description ?? '');
        $prix = floatval($this->app->request()->data->prix ?? 0);
        $categorie_id = intval($this->app->request()->data->categorie_id ?? 0);

        // Validation
        $errors = [];
        
        if (empty($nom)) {
            $errors[] = "Le titre est requis.";
        }
        
        if (empty($description)) {
            $errors[] = "La description est requise.";
        }
        
        if ($prix <= 0) {
            $errors[] = "Le prix estimatif doit être supérieur à 0.";
        }
        
        if ($categorie_id <= 0) {
            $errors[] = "Veuillez sélectionner une catégorie.";
        }

        // Gestion des nouvelles photos
        $photos = explode(',', $produit['photo']);
        $uploadDir = __DIR__ . '/../../public/uploads/';

        if (!empty($_FILES['photos']['name'][0])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            foreach ($_FILES['photos']['name'] as $key => $filename) {
                if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['photos']['tmp_name'][$key];
                    $fileType = $_FILES['photos']['type'][$key];
                    
                    if (!in_array($fileType, $allowedTypes)) {
                        $errors[] = "Le fichier '$filename' n'est pas une image valide.";
                        continue;
                    }
                    
                    if ($_FILES['photos']['size'][$key] > 5 * 1024 * 1024) {
                        $errors[] = "Le fichier '$filename' est trop volumineux (max 5MB).";
                        continue;
                    }
                    
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $newFilename = uniqid('produit_') . '.' . $extension;
                    
                    if (move_uploaded_file($tmpName, $uploadDir . $newFilename)) {
                        $photos[] = $newFilename;
                    }
                }
            }
        }

        // Supprimer les photos sélectionnées
        $photosToDelete = $this->app->request()->data->delete_photos ?? [];
        if (!empty($photosToDelete)) {
            foreach ($photosToDelete as $photoToDelete) {
                $photoPath = $uploadDir . $photoToDelete;
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
                $photos = array_filter($photos, fn($p) => $p !== $photoToDelete);
            }
        }

        $photos = array_filter($photos); // Remove empty values

        if (empty($photos)) {
            $errors[] = "Au moins une photo est requise.";
        }

        if (!empty($errors)) {
            $categories = $produitModel->getAllCategories();
            $produit['nom'] = $nom;
            $produit['description'] = $description;
            $produit['prix'] = $prix;
            $produit['categorie_id'] = $categorie_id;
            
            $this->app->render('produits/edit', [
                'title' => 'Modifier - ' . $nom,
                'produit' => $produit,
                'categories' => $categories,
                'user' => $user,
                'error' => implode('<br>', $errors)
            ]);
            return;
        }

        $photoJson = implode(',', $photos);

        $result = $produitModel->update($id, [
            'nom' => $nom,
            'description' => $description,
            'prix' => $prix,
            'photo' => $photoJson,
            'categorie_id' => $categorie_id
        ]);

        if ($result) {
            $_SESSION['flash_success'] = "Objet modifié avec succès!";
            $this->app->redirect('/mes-produits');
        } else {
            $categories = $produitModel->getAllCategories();
            $this->app->render('produits/edit', [
                'title' => 'Modifier - ' . $nom,
                'produit' => $produit,
                'categories' => $categories,
                'user' => $user,
                'error' => "Erreur lors de la modification."
            ]);
        }
    }

    /**
     * Supprimer un produit
     */
    public function delete(int $id): void {
        $user = $this->requireAuth();
        if (!$user) return;

        $produitModel = new Produit($this->app->db());
        $produit = $produitModel->findByIdAndUser($id, $user['id']);

        if (!$produit) {
            $this->app->redirect('/mes-produits');
            return;
        }

        // Supprimer les photos
        $photos = explode(',', $produit['photo']);
        $uploadDir = __DIR__ . '/../../public/uploads/';
        
        foreach ($photos as $photo) {
            $photoPath = $uploadDir . trim($photo);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $produitModel->delete($id);
        
        $_SESSION['flash_success'] = "Objet supprimé avec succès!";
        $this->app->redirect('/mes-produits');
    }
}
