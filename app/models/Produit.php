<?php

namespace app\models;

use flight\database\PdoWrapper;

class Produit {
    protected PdoWrapper $db;

    public function __construct(PdoWrapper $db) {
        $this->db = $db;
    }

    /**
     * Récupérer tous les produits d'un utilisateur
     */
    public function getAllByUser(int $userId): array {
        return $this->db->fetchAll(
            "SELECT p.*, c.nom as categorie_nom 
             FROM produits p 
             LEFT JOIN categorie c ON p.categorie_id = c.id 
             WHERE p.user_id = ? 
             ORDER BY p.id DESC",
            [$userId]
        ) ?: [];
    }

    /**
     * Récupérer un produit par ID
     */
    public function findById(int $id): ?array {
        return $this->db->fetchRow(
            "SELECT p.*, c.nom as categorie_nom 
             FROM produits p 
             LEFT JOIN categorie c ON p.categorie_id = c.id 
             WHERE p.id = ?",
            [$id]
        ) ?: null;
    }

    /**
     * Récupérer un produit par ID et user_id (pour vérifier la propriété)
     */
    public function findByIdAndUser(int $id, int $userId): ?array {
        return $this->db->fetchRow(
            "SELECT p.*, c.nom as categorie_nom 
             FROM produits p 
             LEFT JOIN categorie c ON p.categorie_id = c.id 
             WHERE p.id = ? AND p.user_id = ?",
            [$id, $userId]
        ) ?: null;
    }

    /**
     * Créer un nouveau produit
     */
    public function create(array $data): int|false {
        $stmt = $this->db->runQuery(
            "INSERT INTO produits (nom, description, prix, photo, categorie_id, user_id) 
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                $data['nom'],
                $data['description'],
                $data['prix'],
                $data['photo'],
                $data['categorie_id'],
                $data['user_id']
            ]
        );
        
        if ($stmt->rowCount() > 0) {
            return (int) $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Mettre à jour un produit
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->runQuery(
            "UPDATE produits 
             SET nom = ?, description = ?, prix = ?, photo = ?, categorie_id = ? 
             WHERE id = ?",
            [
                $data['nom'],
                $data['description'],
                $data['prix'],
                $data['photo'],
                $data['categorie_id'],
                $id
            ]
        );
        return $stmt->rowCount() >= 0;
    }

    /**
     * Supprimer un produit
     */
    public function delete(int $id): bool {
        $stmt = $this->db->runQuery("DELETE FROM produits WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Récupérer toutes les catégories
     */
    public function getAllCategories(): array {
        return $this->db->fetchAll("SELECT * FROM categorie ORDER BY nom") ?: [];
    }

    /**
     * Récupérer tous les produits (pour la page d'accueil publique)
     */
    public function getAll(): array {
        return $this->db->fetchAll(
            "SELECT p.*, c.nom as categorie_nom, u.nom as user_nom 
             FROM produits p 
             LEFT JOIN categorie c ON p.categorie_id = c.id 
             LEFT JOIN users u ON p.user_id = u.id 
             ORDER BY p.id DESC"
        ) ?: [];
    }

    /**
     * Récupérer les produits par catégorie
     */
    public function getByCategorie(int $categorieId): array {
        return $this->db->fetchAll(
            "SELECT p.*, c.nom as categorie_nom, u.nom as user_nom 
             FROM produits p 
             LEFT JOIN categorie c ON p.categorie_id = c.id 
             LEFT JOIN users u ON p.user_id = u.id 
             WHERE p.categorie_id = ? 
             ORDER BY p.id DESC",
            [$categorieId]
        ) ?: [];
    }
}
