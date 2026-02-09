<?php

namespace app\models;

use flight\database\PdoWrapper;

class User {
    protected PdoWrapper $db;

    public function __construct(PdoWrapper $db) {
        $this->db = $db;
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function create(string $nom, string $email, string $motdepasse): bool {
        $hash = password_hash($motdepasse, PASSWORD_DEFAULT);
        $stmt = $this->db->runQuery(
            "INSERT INTO users (nom, email, motdepasse) VALUES (?, ?, ?)",
            [$nom, $email, $hash]
        );
        return $stmt->rowCount() > 0;
    }

    /**
     * Trouver un utilisateur par email
     */
    public function findByEmail(string $email): ?array {
        return $this->db->fetchRow("SELECT * FROM users WHERE email = ?", [$email]) ?: null;
    }

    /**
     * Trouver un utilisateur par ID
     */
    public function findById(int $id): ?array {
        return $this->db->fetchRow("SELECT * FROM users WHERE id = ?", [$id]) ?: null;
    }

    /**
     * Vérifier le mot de passe
     */
    public function verifyPassword(string $motdepasse, string $hash): bool {
        return password_verify($motdepasse, $hash);
    }

    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists(string $email): bool {
        $result = $this->db->fetchRow("SELECT id FROM users WHERE email = ?", [$email]);
        return !empty($result);
    }
}
