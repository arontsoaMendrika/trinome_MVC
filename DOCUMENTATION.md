# E-Takalo - Plateforme d'échange d'objets

## 📋 Description
E-Takalo est une plateforme web permettant aux utilisateurs d'échanger des objets entre eux (vêtements, livres, DVD, électronique, etc.). Les utilisateurs peuvent s'inscrire, mettre en ligne leurs objets et consulter le catalogue des objets disponibles.

## 👥 Équipe de développement
- Membre 1
- Membre 2
- Membre 3

## 🚀 Fonctionnalités

### ✅ Implémentées
- **Authentification**
  - Page d'inscription avec validation des données
  - Page de connexion
  - Déconnexion
  - Gestion de session

- **Gestion des objets**
  - Ajout d'objets (titre, description, photo, prix estimatif, catégorie)
  - Modification d'objets
  - Suppression d'objets
  - Liste des objets de l'utilisateur

- **Catalogue**
  - Consultation des objets des autres utilisateurs
  - Affichage des détails d'un objet
  - Contact du propriétaire par email

### 🔄 À venir
- Système de proposition d'échange
- Historique des échanges
- Système de statuts d'échange
- Notifications
- Messagerie interne

## 🛠 Technologies utilisées
- **Backend**: PHP 8+ avec FlightPHP Framework
- **Base de données**: MySQL
- **Frontend**: 
  - HTML5, CSS3, JavaScript
  - Bootstrap 5
  - Bootstrap Icons
  - AOS (Animate On Scroll)
- **Architecture**: MVC (Model-View-Controller)

## 📦 Installation

### Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Composer
- Serveur web (Apache/Nginx)

### Étapes d'installation

1. **Cloner le projet**
```bash
cd /chemin/vers/le/projet
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Créer la base de données**
```bash
mysql -u root -p
```

Puis exécuter les scripts SQL:
```sql
source public/base.sql
source public/insert.sql
```

4. **Configurer la base de données**
Éditer le fichier [app/config/config.php](app/config/config.php):
```php
'database' => [
    'host'     => 'localhost',
    'dbname'   => 'takalo',
    'user'     => 'root',      // Votre utilisateur MySQL
    'password' => '',          // Votre mot de passe MySQL
],
```

5. **Configurer le serveur web**

Pour Apache, le fichier [public/.htaccess](public/.htaccess) est déjà configuré.

Pour PHP built-in server (développement):
```bash
php -S localhost:8000 -t public
```

6. **Accéder à l'application**
Ouvrir le navigateur: `http://localhost:8000`

## 📁 Structure du projet
```
trinome_MVC/
├── app/
│   ├── config/          # Configuration de l'application
│   │   ├── bootstrap.php
│   │   ├── config.php   # Configuration DB et app
│   │   ├── routes.php   # Définition des routes
│   │   └── services.php # Services et dépendances
│   ├── controllers/     # Contrôleurs MVC
│   │   ├── AuthController.php
│   │   └── ProduitController.php
│   ├── models/          # Modèles de données
│   │   ├── User.php
│   │   └── Produit.php
│   ├── views/           # Vues (templates)
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   └── produits/
│   │       ├── mes-objets.php
│   │       └── catalogue.php
│   └── middlewares/     # Middlewares
├── public/              # Dossier public (web root)
│   ├── index.php        # Point d'entrée
│   ├── css/             # Fichiers CSS
│   ├── js/              # Fichiers JavaScript
│   ├── vendor/          # Assets frontend (Bootstrap, etc.)
│   ├── uploads/         # Photos des produits
│   ├── base.sql         # Script de création DB
│   └── insert.sql       # Données de test
└── vendor/              # Dépendances Composer (backend)
```

## 🗄 Base de données

### Tables principales
- **users**: Utilisateurs du système
- **produits**: Objets mis en ligne par les utilisateurs
- **categorie**: Catégories d'objets
- **historique**: Historique des échanges
- **status_echange**: Statuts des échanges

Voir [public/base.sql](public/base.sql) pour le schéma complet.

## 🎨 Design
Le design utilise:
- **Bootstrap 5** pour le layout responsive
- **Bootstrap Icons** pour les icônes
- **AOS** pour les animations au scroll
- **Gradient violet/bleu** pour la charte graphique

## 📝 Routes disponibles

### Authentification
- `GET /` - Redirection vers login ou mes-objets
- `GET /login` - Page de connexion
- `POST /login` - Traitement de la connexion
- `GET /inscription` - Page d'inscription
- `POST /inscription` - Traitement de l'inscription
- `GET /logout` - Déconnexion

### Produits
- `GET /mes-objets` - Liste des objets de l'utilisateur
- `GET /catalogue` - Catalogue de tous les objets
- `POST /produits/ajouter` - Ajout d'un objet
- `POST /produits/modifier` - Modification d'un objet
- `GET /produits/supprimer/{id}` - Suppression d'un objet

## 🔒 Sécurité
- Mots de passe hashés avec `password_hash()`
- Protection CSRF via sessions
- Validation des données côté serveur
- Upload de fichiers sécurisé
- Headers de sécurité configurés

## 🧪 Tests

### Comptes de test
Après avoir exécuté `insert.sql`, vous pouvez utiliser:
- Email: `rakoto@gmail.com` / Mot de passe: `takalo123`
- Email: `marie.jeanne@yahoo.fr` / Mot de passe: `takalo123`
- Email: `jean.dupont@outlook.com` / Mot de passe: `takalo123`

## 📖 Utilisation

1. **S'inscrire** sur la plateforme
2. **Se connecter** avec ses identifiants
3. **Ajouter des objets** depuis "Mes objets"
4. **Consulter le catalogue** pour voir les objets des autres
5. **Contacter** un propriétaire pour proposer un échange

## 🐛 Débogage
Le projet utilise Tracy Debugger:
- En développement, la barre de débogage s'affiche automatiquement
- Les erreurs sont loggées dans `app/log/`

## 📄 Licence
Ce projet est développé dans le cadre d'un projet académique.

## 📞 Contact
Pour toute question, contactez l'équipe de développement.
