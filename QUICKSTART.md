# 🚀 Guide de démarrage rapide - E-Takalo

## ⚡ Installation en 5 minutes

### 1. Base de données
Créer la base de données MySQL :
```bash
mysql -u root -p
```

Dans MySQL :
```sql
source public/base.sql
source public/insert.sql
exit;
```

### 2. Configuration
Vérifier/modifier la configuration dans `app/config/config.php` :
```php
'database' => [
    'host'     => 'localhost',
    'dbname'   => 'takalo',
    'user'     => 'root',
    'password' => '',  // Modifier si vous avez un mot de passe
],
```

### 3. Démarrer le serveur
```bash
cd /home/sanda/Outils/S3/JIRO/trinome_MVC
php -S localhost:8000 -t public
```

### 4. Accéder à l'application
Ouvrir le navigateur : **http://localhost:8000**

---

## 🧪 Comptes de test

Après avoir exécuté `insert.sql`, vous pouvez vous connecter avec :

| Email | Mot de passe |
|-------|--------------|
| rakoto@gmail.com | takalo123 |
| marie.jeanne@yahoo.fr | takalo123 |
| jean.dupont@outlook.com | takalo123 |

---

## 📋 Checklist de vérification

- [ ] MySQL installé et démarré
- [ ] Base de données `takalo` créée
- [ ] Tables créées avec `base.sql`
- [ ] Données de test insérées avec `insert.sql`
- [ ] Configuration DB dans `app/config/config.php`
- [ ] Dossier `public/uploads/` créé et accessible en écriture
- [ ] Serveur PHP démarré

---

## 🎯 Premiers pas

1. **S'inscrire** : Créer un nouveau compte
2. **Ajouter un objet** : Cliquer sur "Ajouter un objet" dans "Mes objets"
3. **Explorer** : Aller dans "Catalogue" pour voir les objets des autres
4. **Échanger** : Cliquer sur un objet et contacter le propriétaire

---

## 🐛 Problèmes courants

### Erreur de connexion à la base de données
- Vérifier que MySQL est démarré
- Vérifier les identifiants dans `config.php`
- Vérifier que la base `takalo` existe

### Erreur d'upload de photo
```bash
chmod 755 public/uploads
```

### Page blanche
- Vérifier les logs dans `app/log/`
- Activer l'affichage des erreurs PHP

---

## 📞 Support
En cas de problème, consulter [DOCUMENTATION.md](DOCUMENTATION.md)
