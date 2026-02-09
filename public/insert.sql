INSERT INTO users (nom, email, motdepasse) VALUES
('Rakoto Andrianina',  'rakoto@gmail.com',     'takalo123'),
('Marie Jeanne',       'marie.jeanne@yahoo.fr','takalo123'),
('Jean Dupont',        'jean.dupont@outlook.com','takalo123'),
('Miora Rasoa',        'miora.rasoa@gmail.com',  'takalo123'),
('Tiana Razafy',       'tiana@gmail.com',        'takalo123');

-- 2. Catégories (très utilisées à Madagascar pour le troc)
INSERT INTO categorie (nom) VALUES
('Téléphones & Tablettes'),
('Ordinateurs & Accessoires'),
('Vêtements & Chaussures'),
('Meubles & Décoration'),
('Électroménager'),
('Livres & Scolaire'),
('Vélos & Motos'),
('Instruments de musique'),
('Jeux & Jouets'),
('Autres');

-- 3. Statuts d'échange (très important pour suivre l'historique)
INSERT INTO status_echange (nom) VALUES
('Proposé'),
('En attente de validation'),
('Accepté'),
('Échange effectué'),
('Refusé'),
('Annulé'),
('Échange terminé avec note');

-- 4. Produits (quelques exemples réalistes)
INSERT INTO produits (nom, description, prix, photo, categorie_id, user_id) VALUES
('iPhone 11 128Go', 'Très bon état, vendu avec chargeur et coque', 850000, 'iphone11_noir.jpg', 1, 1),
('Canapé 3 places tissu beige', 'Peu utilisé, bon état général', 450000, 'canape_beige.jpg', 4, 2),
('Vélo VTT Rockrider 520', 'Taille M, 2 ans d utilisation, freins à disque', 380000, 'vtt_rockrider.jpg', 7, 3),
('Robe traditionnelle malgache neuve', 'Taille M, tissu lamba landy', 95000, 'robe_tradi.jpg', 3, 4),
('Guitare folk acoustique', 'Yamaha F310, très bon état', 280000, 'guitare_yamaha.jpg', 8, 5),
('Machine à laver semi-automatique 8kg', 'Fonctionne parfaitement', 420000, 'machine_a_laver.jpg', 5, 1),
('Pack 15 livres scolaires + romans', 'Terminale + Terminale + romans malgaches', 65000, 'livres_scolaires.jpg', 6, 2),
('Samsung Galaxy A52 5G', '128Go, écran impeccable', 620000, 'samsung_a52.jpg', 1, 3),
('Chaussures Nike Air Force 1', 'Taille 42, presque neuves', 180000, 'nike_air_force.jpg', 3, 4),
('Bureau gamer avec LED', 'Avec support écran et rangements', 320000, 'bureau_gamer.jpg', 4, 5);


-- 5. Quelques lignes d'historique (échanges passés ou en cours)
INSERT INTO historique (user_id, produit_id, status_echange_id, date_echange) VALUES
(1, 3, 4, '2025-11-12'),          -- Rakoto a échangé son iPhone contre le VTT
(3, 1, 4, '2025-11-12'),          -- Jean a donné son VTT contre l'iPhone
(2, 6, 3, '2026-01-08'),          -- Marie a proposé sa machine à laver
(1, 6, 2, '2026-01-09'),          -- Rakoto a répondu → en attente
(4, 8, 1, '2026-02-01'),          -- Miora propose son Samsung contre la robe
(5, 4, 1, '2026-02-01');          -- Tiana propose la robe contre le Samsung,,