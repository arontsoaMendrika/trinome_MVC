<?php

namespace app\models;

class User {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public function create($nom, $email, $motdepasse) {
        $hashedPassword = password_hash($motdepasse, PASSWORD_DEFAULT);
        $this->db->runQuery("INSERT INTO users (nom, email, motdepasse) VALUES (?, ?, ?)", [$nom, $email, $hashedPassword]);
        return true;
    }
    
    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists($email) {
        $result = $this->db->fetchField("SELECT COUNT(*) FROM users WHERE email = ?", [$email]);
        return intval($result) > 0;
    }
    
    /**
     * Authentifier un utilisateur
     */
    public function authenticate($email, $motdepasse) {
        $row = $this->db->fetchRow("SELECT * FROM users WHERE email = ?", [$email]);
        
        // fetchRow retourne une Collection vide si aucun résultat
        // Un objet est toujours truthy en PHP, il faut vérifier count()
        if (!$row || (is_object($row) && count($row) === 0)) {
            return false;
        }
        
        // Convertir Collection en tableau si nécessaire
        $user = is_array($row) ? $row : $row->getData();
        
        // Vérifier que la clé motdepasse existe
        if (!isset($user['motdepasse'])) {
            return false;
        }
        
        if (password_verify($motdepasse, $user['motdepasse'])) {
            return $user;
        }
        return false;
    }
    
    /**
     * Récupérer un utilisateur par ID
     */
    public function findById($id) {
        $row = $this->db->fetchRow("SELECT id, nom, email FROM users WHERE id = ?", [$id]);
        if (!$row || (is_object($row) && count($row) === 0)) return null;
        return is_array($row) ? $row : $row->getData();
    }
    
    /**
     * Récupérer tous les utilisateurs
     */
    public function findAll() {
        $rows = $this->db->fetchAll("SELECT id, nom, email FROM users ORDER BY nom");
        return array_map(function($row) {
            return is_array($row) ? $row : $row->getData();
        }, $rows);
    }
}
