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
    public function create($nom, $description, $prix, $photo, $categorie_id, $user_id) {
        $this->db->runQuery(
            "INSERT INTO produits (nom, description, prix, photo, categorie_id, user_id) VALUES (?, ?, ?, ?, ?, ?)",
            [$nom, $description, $prix, $photo, $categorie_id, $user_id]
        );
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
        return $this->toArray($rows);
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
        return $this->toArray($rows);
    }
    
    /**
     * Récupérer un produit par ID
     */
    public function findById($id) {
        $row = $this->db->fetchRow("
            SELECT p.*, c.nom as categorie_nom, u.nom as proprietaire, u.email as proprietaire_email 
            FROM produits p
            LEFT JOIN categorie c ON p.categorie_id = c.id
            LEFT JOIN users u ON p.user_id = u.id
            WHERE p.id = ?
        ", [$id]);
        return $this->rowToArray($row);
    }
    
    /**
     * Mettre à jour un produit
     */
    public function update($id, $nom, $description, $prix, $photo, $categorie_id) {
        if ($photo) {
            $this->db->runQuery(
                "UPDATE produits SET nom = ?, description = ?, prix = ?, photo = ?, categorie_id = ? WHERE id = ?",
                [$nom, $description, $prix, $photo, $categorie_id, $id]
            );
        } else {
            $this->db->runQuery(
                "UPDATE produits SET nom = ?, description = ?, prix = ?, categorie_id = ? WHERE id = ?",
                [$nom, $description, $prix, $categorie_id, $id]
            );
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
