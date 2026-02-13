# 📸 Captures d'écran et Guide Visuel - E-Takalo

## 🏠 Page d'accueil

### Fonctionnalités visibles :
- **Hero section** avec dégradé violet/bleu
- Logo et nom du site "E-Takalo"
- Description du service
- 2 boutons d'action :
  - "Commencer maintenant" (inscription)
  - "Se connecter"
- **Statistiques** :
  - 1000+ Utilisateurs
  - 5000+ Objets
  - 3000+ Échanges
- **3 cartes de fonctionnalités** :
  1. Mettre des objets en ligne
  2. Explorer le catalogue
  3. Échanger simplement

### Design :
- Animations AOS (fade, zoom)
- Cards blanches avec ombre
- Dégradé de fond
- Responsive

---

## 🔐 Page de connexion

### Éléments :
- En-tête avec logo et description
- Formulaire de connexion :
  - Champ Email (avec icône enveloppe)
  - Champ Mot de passe (avec icône cadenas)
  - Bouton "Se connecter"
- Lien vers l'inscription
- Affichage des messages de succès/erreur

### Design :
- Card centrée sur fond dégradé
- Header coloré (dégradé violet/bleu)
- Corps blanc avec padding
- Bouton full-width avec dégradé
- Animation d'entrée

---

## ✍️ Page d'inscription

### Éléments :
- Formulaire d'inscription :
  - Nom complet
  - Email
  - Mot de passe (min 6 caractères)
  - Confirmation mot de passe
  - Bouton "S'inscrire"
- Lien vers la connexion
- Messages d'erreur (si validation échoue)

### Validations :
- Email valide
- Mots de passe identiques
- Longueur minimale du mot de passe
- Email unique

---

## 📦 Page "Mes objets"

### Navigation :
- **Navbar** avec :
  - Logo E-Takalo (cliquable)
  - Lien "Mes objets" (actif)
  - Lien "Catalogue"
  - Menu utilisateur avec nom et déconnexion

### Contenu principal :
- Titre "Mes objets" avec icône
- Bouton "Ajouter un objet" (en haut à droite)
- Grille de cartes (3 colonnes sur desktop) :
  - Image du produit
  - Badge de catégorie
  - Nom du produit
  - Description (tronquée)
  - Prix en Ariary
  - 2 boutons : "Modifier" et "Supprimer"

### Modal d'ajout :
- Formulaire avec :
  - Titre de l'objet
  - Description (textarea)
  - Prix estimatif (nombre)
  - Catégorie (select)
  - Photo (file upload)
- Boutons : "Annuler" et "Ajouter"

### Modal de modification :
- Même formulaire que l'ajout
- Pré-rempli avec les données existantes
- Option de changer la photo (optionnel)

---

## 🛒 Page "Catalogue"

### Navigation :
- Navbar identique
- Lien "Catalogue" actif

### Contenu :
- Titre "Catalogue des objets disponibles"
- Sous-titre explicatif
- Grille de cartes (3 colonnes) :
  - Image du produit
  - Badge de catégorie
  - Nom du produit
  - Description
  - Prix
  - **Propriétaire** (nouveau champ)
  - Bouton "Voir les détails"

### Modal de détails :
- Layout 2 colonnes :
  - Gauche : Image grande taille
  - Droite : Informations complètes
    - Catégorie
    - Prix
    - Propriétaire
    - Contact (email)
    - Description complète
    - Alert info (instructions d'échange)
- Boutons : "Fermer" et "Contacter"

---

## 🎨 Charte graphique

### Couleurs principales :
```css
Primary: #667eea (Bleu-violet)
Secondary: #764ba2 (Violet)
Success: #28a745 (Vert)
Danger: #dc3545 (Rouge)
Warning: #ffc107 (Jaune)
Info: #17a2b8 (Bleu clair)
```

### Dégradés :
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Typographie :
- Police : Segoe UI, Tahoma, Geneva, Verdana
- Titres : Bold
- Corps : Regular

### Espacements :
- Cards : margin-bottom: 20px
- Padding cards : 30px
- Border-radius : 15px

### Ombres :
```css
box-shadow: 0 5px 15px rgba(0,0,0,0.1);
hover: 0 10px 40px rgba(0,0,0,0.15);
```

---

## 📱 Responsive

### Breakpoints Bootstrap :
- **Mobile** (< 576px) : 1 colonne
- **Tablet** (576px - 768px) : 2 colonnes
- **Desktop** (> 768px) : 3 colonnes

### Adaptations :
- Navbar : Menu hamburger sur mobile
- Cards : Stack verticalement
- Boutons : Full-width sur mobile
- Modal : Full-screen sur mobile

---

## ⚡ Animations

### AOS (Animate On Scroll) :
```html
data-aos="fade-up"
data-aos="fade-right"
data-aos="fade-left"
data-aos="zoom-in"
data-aos-delay="100"
```

### Transitions CSS :
- Cards : transform translateY(-5px) au hover
- Boutons : transform translateY(-2px) au hover
- Durée : 0.3s ease

---

## 🎯 Icônes utilisées

### Bootstrap Icons :
- `bi-arrow-left-right` : Logo E-Takalo
- `bi-person-circle` : Profil utilisateur
- `bi-box-seam` : Objets/Produits
- `bi-grid` : Catalogue
- `bi-plus-circle` : Ajouter
- `bi-pencil` : Modifier
- `bi-trash` : Supprimer
- `bi-eye` : Voir détails
- `bi-envelope` : Email
- `bi-lock` : Mot de passe
- `bi-box-arrow-right` : Déconnexion
- `bi-person-plus` : Inscription

---

## 💡 Notes de design

1. **Cohérence** : Même palette de couleurs sur toutes les pages
2. **Feedback visuel** : Animations au hover, messages de confirmation
3. **Accessibilité** : Contrastes suffisants, labels explicites
4. **Performance** : Images optimisées, animations légères
5. **UX** : Moins de 3 clics pour toute action importante
