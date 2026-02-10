<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes objets - E-Takalo</title>
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/vendor/aos/aos.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/mes-objets">
                <i class="bi bi-arrow-left-right"></i> E-Takalo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/mes-objets">
                            <i class="bi bi-box-seam"></i> Mes objets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/catalogue">
                            <i class="bi bi-grid"></i> Catalogue
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($user_nom) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/logout">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="bi bi-box-seam"></i> Mes objets</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-circle"></i> Ajouter un objet
                    </button>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row">
            <?php if (empty($produits)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Vous n'avez pas encore d'objets. Cliquez sur "Ajouter un objet" pour commencer !
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($produits as $produit): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up">
                        <div class="card">
                            <img src="/uploads/<?= htmlspecialchars($produit['photo']) ?>" 
                                 class="card-img-top product-image" 
                                 alt="<?= htmlspecialchars($produit['nom']) ?>"
                                 onerror="this.src='https://via.placeholder.com/300x200?text=Photo+indisponible'">
                            <div class="card-body">
                                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($produit['categorie_nom'] ?? 'Sans catégorie') ?></span>
                                <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars(substr($produit['description'], 0, 100)) ?>...</p>
                                <p class="fw-bold text-success"><?= number_format($produit['prix'], 0, ',', ' ') ?> Ar</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary flex-fill" 
                                            onclick='editProduit(<?= json_encode($produit) ?>)'>
                                        <i class="bi bi-pencil"></i> Modifier
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteProduit(<?= $produit['id'] ?>, '<?= htmlspecialchars($produit['nom']) ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Ajout -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Ajouter un objet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/produits/ajouter" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Titre de l'objet</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix estimatif (Ar)</label>
                            <input type="number" class="form-control" id="prix" name="prix" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">Catégorie</label>
                            <select class="form-select" id="categorie_id" name="categorie_id" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modification -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil"></i> Modifier l'objet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/produits/modifier" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nom" class="form-label">Titre de l'objet</label>
                            <input type="text" class="form-control" id="edit_nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_prix" class="form-label">Prix estimatif (Ar)</label>
                            <input type="number" class="form-control" id="edit_prix" name="prix" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_categorie_id" class="form-label">Catégorie</label>
                            <select class="form-select" id="edit_categorie_id" name="categorie_id" required>
                                <option value="">Sélectionner une catégorie</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_photo" class="form-label">Nouvelle photo (optionnel)</label>
                            <input type="file" class="form-control" id="edit_photo" name="photo" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/aos/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        function editProduit(produit) {
            document.getElementById('edit_id').value = produit.id;
            document.getElementById('edit_nom').value = produit.nom;
            document.getElementById('edit_description').value = produit.description;
            document.getElementById('edit_prix').value = produit.prix;
            document.getElementById('edit_categorie_id').value = produit.categorie_id;
            
            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        function deleteProduit(id, nom) {
            if (confirm('Êtes-vous sûr de vouloir supprimer "' + nom + '" ?')) {
                window.location.href = '/produits/supprimer/' + id;
            }
        }
    </script>
</body>
</html>
