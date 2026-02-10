-- Script de configuration initiale pour E-Takalo
-- Ce script créé la base de données et les tables nécessaires

-- Créer la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS takalo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE takalo;

-- Supprimer les tables si elles existent (pour réinitialisation)
DROP TABLE IF EXISTS historique;
DROP TABLE IF EXISTS produits;
DROP TABLE IF EXISTS status_echange;
DROP TABLE IF EXISTS categorie;
DROP TABLE IF EXISTS users;

-- Table des utilisateurs
CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    motdepasse VARCHAR(250) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des catégories
CREATE TABLE categorie(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des produits
CREATE TABLE produits(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) DEFAULT 0,
    photo VARCHAR(250) DEFAULT 'default.jpg',
    categorie_id INT,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_categorie (categorie_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des statuts d'échange
CREATE TABLE status_echange(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table de l'historique des échanges
CREATE TABLE historique(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    produit_id INT NOT NULL,
    status_echange_id INT NOT NULL,
    date_echange DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
    FOREIGN KEY (status_echange_id) REFERENCES status_echange(id),
    INDEX idx_user (user_id),
    INDEX idx_produit (produit_id),
    INDEX idx_date (date_echange)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Message de confirmation
SELECT 'Base de données E-Takalo créée avec succès!' as Message;
