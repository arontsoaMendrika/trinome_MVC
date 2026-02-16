CREATE DATABASE takalo;
USE takalo;

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100),
    email VARCHAR(100),
    motdepasse VARCHAR(250)
);

CREATE TABLE categorie(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100)
);

CREATE TABLE produits(
        id INT PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(100),
        description VARCHAR(250),
        prix DECIMAL(10,2),
        categorie_id INT ,
        FOREIGN KEY (categorie_id )        REFERENCES categorie(id),
        user_id INT ,
        FOREIGN KEY (user_id)        REFERENCES users(id)
);

CREATE TABLE produit_photos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    produit_id INT,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
    photo VARCHAR(250),
    ordre INT DEFAULT 0
);

CREATE TABLE status_echange(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100)
);

CREATE TABLE historique(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT ,
    FOREIGN KEY (user_id)        REFERENCES users(id),
    produit_id INT ,
    FOREIGN KEY (produit_id)        REFERENCES produits(id),
    status_echange_id INT ,
    FOREIGN KEY (status_echange_id)        REFERENCES status_echange(id),
    date_echange DATE
);

