<?php

namespace app\models;

class Produit {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Convertir les résultats Collection en tableaux
     */
    private function toArray($rows) {
        return array_map(function($row) {
            return is_array($row) ? $row : $row->getData();
        }, $rows);
    }
    
    private function rowToArray($row) {
        if (!$row || (is_object($row) && count($row) === 0)) return null;
        return is_array($row) ? $row : $row->getData();
    }
    
    /**
     * Créer un nouveau produit
     */
    public function create($nom, $description, $prix, $photos, $categorie_id, $user_id) {
        $this->db->runQuery(
            "INSERT INTO produits (nom, description, prix, categorie_id, user_id) VALUES (?, ?, ?, ?, ?)",
            [$nom, $description, $prix, $categorie_id, $user_id]
        );
        $produit_id = $this->db->lastInsertId();
        
        // Ajouter les photos
        if (!empty($photos)) {
            foreach ($photos as $index => $photo) {
                $this->db->runQuery(
                    "INSERT INTO produit_photos (produit_id, photo, ordre) VALUES (?, ?, ?)",
                    [$produit_id, $photo, $index]
                );
            }
        }
        
        return true;
    }
    
    /**
     * Récupérer tous les produits d'un utilisateur
     */
    public function findByUserId($user_id) {
        $rows = $this->db->fetchAll("
            SELECT p.*, c.nom as categorie_nom 
            FROM produits p
            LEFT JOIN categorie c ON p.categorie_id = c.id
            WHERE p.user_id = ?
            ORDER BY p.id DESC
        ", [$user_id]);
        
        $produits = $this->toArray($rows);
        
        // Ajouter les photos pour chaque produit
        foreach ($produits as &$produit) {
            $produit['photos'] = $this->getPhotosByProduitId($produit['id']);
            // Garder la première photo pour la compatibilité
            $produit['photo'] = !empty($produit['photos']) ? $produit['photos'][0]['photo'] : 'default.jpg';
        }
        
        return $produits;
    }
    
    /**
     * Récupérer tous les produits (sauf ceux de l'utilisateur connecté)
     */
    public function findAllExcept($user_id = null) {
        if ($user_id) {
            $rows = $this->db->fetchAll("
                SELECT p.*, c.nom as categorie_nom, u.nom as proprietaire 
                FROM produits p
                LEFT JOIN categorie c ON p.categorie_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.user_id != ?
                ORDER BY p.id DESC
            ", [$user_id]);
        } else {
            $rows = $this->db->fetchAll("
                SELECT p.*, c.nom as categorie_nom, u.nom as proprietaire 
                FROM produits p
                LEFT JOIN categorie c ON p.categorie_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                ORDER BY p.id DESC
            ");
        }
        
        $produits = $this->toArray($rows);
        
        // Ajouter les photos pour chaque produit
        foreach ($produits as &$produit) {
            $produit['photos'] = $this->getPhotosByProduitId($produit['id']);
            // Garder la première photo pour la compatibilité
            $produit['photo'] = !empty($produit['photos']) ? $produit['photos'][0]['photo'] : 'default.jpg';
        }
        
        return $produits;
    }
    
    /**
     * Récupérer les photos d'un produit
     */
    public function getPhotosByProduitId($produit_id) {
        $rows = $this->db->fetchAll("
            SELECT * FROM produit_photos 
            WHERE produit_id = ? 
            ORDER BY ordre ASC
        ", [$produit_id]);
        return $this->toArray($rows);
    }
    
    /**
     * Mettre à jour un produit
     */
    public function update($id, $nom, $description, $prix, $photos, $categorie_id) {
        // Mettre à jour les informations de base du produit
        $this->db->runQuery(
            "UPDATE produits SET nom = ?, description = ?, prix = ?, categorie_id = ? WHERE id = ?",
            [$nom, $description, $prix, $categorie_id, $id]
        );
        
        // Supprimer les anciennes photos
        $this->db->runQuery("DELETE FROM produit_photos WHERE produit_id = ?", [$id]);
        
        // Ajouter les nouvelles photos
        if (!empty($photos)) {
            foreach ($photos as $index => $photo) {
                $this->db->runQuery(
                    "INSERT INTO produit_photos (produit_id, photo, ordre) VALUES (?, ?, ?)",
                    [$id, $photo, $index]
                );
            }
        }
        
        return true;
    }
    
    /**
     * Supprimer un produit
     */
    public function delete($id, $user_id) {
        $this->db->runQuery("DELETE FROM produits WHERE id = ? AND user_id = ?", [$id, $user_id]);
        return true;
    }
    
    /**
     * Récupérer toutes les catégories
     */
    public function getCategories() {
        $rows = $this->db->fetchAll("SELECT * FROM categorie ORDER BY nom");
        return $this->toArray($rows);
    }
}
