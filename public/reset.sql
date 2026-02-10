-- Script de nettoyage et réinitialisation de la base E-Takalo
-- ATTENTION : Ce script supprime TOUTES les données !

USE takalo;

-- Désactiver les vérifications de clés étrangères temporairement
SET FOREIGN_KEY_CHECKS = 0;

-- Vider toutes les tables
TRUNCATE TABLE historique;
TRUNCATE TABLE produits;
TRUNCATE TABLE users;
TRUNCATE TABLE categorie;
TRUNCATE TABLE status_echange;

-- Réactiver les vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;

-- Réinitialiser les AUTO_INCREMENT
ALTER TABLE historique AUTO_INCREMENT = 1;
ALTER TABLE produits AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE categorie AUTO_INCREMENT = 1;
ALTER TABLE status_echange AUTO_INCREMENT = 1;

-- Message de confirmation
SELECT 'Base de données nettoyée avec succès!' as Message;
SELECT 'Vous pouvez maintenant exécuter insert.sql pour réinsérer les données de test' as Information;
