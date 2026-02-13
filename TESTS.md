# 🧪 Tests E-Takalo

## Tests manuels à effectuer

### ✅ Test 1 : Installation de la base de données
- [ ] Exécuter `setup.sql` ou `base.sql`
- [ ] Vérifier que toutes les tables sont créées
- [ ] Exécuter `insert.sql`
- [ ] Vérifier que les données sont insérées

```sql
USE takalo;
SHOW TABLES;
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM produits;
SELECT COUNT(*) FROM categorie;
```

### ✅ Test 2 : Page d'accueil
- [ ] Accéder à `http://localhost:8000`
- [ ] Vérifier que la page d'accueil s'affiche
- [ ] Vérifier les animations AOS
- [ ] Cliquer sur "Commencer maintenant" → redirige vers inscription
- [ ] Cliquer sur "Se connecter" → redirige vers login

### ✅ Test 3 : Inscription
- [ ] Remplir le formulaire avec des données valides
- [ ] Tester avec un email déjà existant (doit échouer)
- [ ] Tester avec des mots de passe différents (doit échouer)
- [ ] Tester avec un mot de passe < 6 caractères (doit échouer)
- [ ] Inscription réussie → redirection vers login

### ✅ Test 4 : Connexion
- [ ] Se connecter avec un compte de test
  - Email : `rakoto@gmail.com`
  - Mot de passe : `takalo123`
- [ ] Connexion réussie → redirection vers "Mes objets"
- [ ] Tester avec un mauvais mot de passe (doit échouer)
- [ ] Vérifier que le nom de l'utilisateur s'affiche dans la navbar

### ✅ Test 5 : Ajout d'objet
- [ ] Cliquer sur "Ajouter un objet"
- [ ] Remplir le formulaire :
  - Nom : "Test Objet"
  - Description : "Ceci est un test"
  - Prix : 50000
  - Catégorie : Sélectionner une catégorie
  - Photo : Uploader une image
- [ ] Soumettre le formulaire
- [ ] Vérifier que l'objet apparaît dans "Mes objets"

### ✅ Test 6 : Modification d'objet
- [ ] Cliquer sur "Modifier" sur un objet
- [ ] Modifier les informations
- [ ] Soumettre
- [ ] Vérifier que les modifications sont sauvegardées

### ✅ Test 7 : Suppression d'objet
- [ ] Cliquer sur le bouton de suppression
- [ ] Confirmer la suppression
- [ ] Vérifier que l'objet est supprimé

### ✅ Test 8 : Catalogue
- [ ] Aller dans "Catalogue"
- [ ] Vérifier que les objets des autres utilisateurs s'affichent
- [ ] Vérifier que les objets de l'utilisateur connecté n'apparaissent PAS
- [ ] Cliquer sur "Voir les détails"
- [ ] Vérifier que le modal s'affiche avec toutes les informations

### ✅ Test 9 : Contact propriétaire
- [ ] Dans le catalogue, cliquer sur "Contacter"
- [ ] Vérifier que le client email s'ouvre avec :
  - Email du propriétaire pré-rempli
  - Sujet contenant le nom de l'objet

### ✅ Test 10 : Déconnexion
- [ ] Cliquer sur le menu utilisateur
- [ ] Cliquer sur "Déconnexion"
- [ ] Vérifier la redirection vers la page de login
- [ ] Essayer d'accéder à `/mes-objets` → doit rediriger vers login

### ✅ Test 11 : Sécurité
- [ ] Sans être connecté, tenter d'accéder à `/mes-objets`
  - Doit rediriger vers `/login`
- [ ] Sans être connecté, tenter d'accéder à `/catalogue`
  - Doit rediriger vers `/login`
- [ ] Connecté en tant qu'utilisateur A, tenter de supprimer un produit d'utilisateur B
  - Doit échouer (vérifier dans la DB)

### ✅ Test 12 : Upload de photos
- [ ] Uploader une image JPG → OK
- [ ] Uploader une image PNG → OK
- [ ] Uploader un fichier PDF → Devrait échouer ou être ignoré
- [ ] Vérifier que les images sont dans `public/uploads/`
- [ ] Vérifier que les images s'affichent correctement

### ✅ Test 13 : Responsive design
- [ ] Tester sur mobile (mode développeur)
- [ ] Tester sur tablette
- [ ] Vérifier que le menu hamburger fonctionne
- [ ] Vérifier que les cartes s'adaptent

### ✅ Test 14 : Messages flash
- [ ] Vérifier les messages de succès après actions
- [ ] Vérifier les messages d'erreur
- [ ] Vérifier que les messages disparaissent automatiquement

## 🐛 Bugs connus à corriger
- [ ] Aucun pour le moment

## ✨ Améliorations futures
- [ ] Système de proposition d'échange direct
- [ ] Système de notation des utilisateurs
- [ ] Messagerie interne
- [ ] Notifications en temps réel
- [ ] Recherche avancée avec filtres
- [ ] Géolocalisation
- [ ] Favoris

## 📊 Résultats des tests

| Test | Statut | Date | Testeur |
|------|--------|------|---------|
| Installation DB | ⏳ | - | - |
| Page d'accueil | ⏳ | - | - |
| Inscription | ⏳ | - | - |
| Connexion | ⏳ | - | - |
| Ajout objet | ⏳ | - | - |
| Modification objet | ⏳ | - | - |
| Suppression objet | ⏳ | - | - |
| Catalogue | ⏳ | - | - |
| Contact | ⏳ | - | - |
| Déconnexion | ⏳ | - | - |
| Sécurité | ⏳ | - | - |
| Upload photos | ⏳ | - | - |
| Responsive | ⏳ | - | - |
| Messages flash | ⏳ | - | - |

**Légende** : ✅ Passé | ❌ Échoué | ⏳ En attente
