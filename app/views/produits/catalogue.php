<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - E-Takalo</title>
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
                        <a class="nav-link" href="/mes-objets">
                            <i class="bi bi-box-seam"></i> Mes objets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/catalogue">
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
                <h2><i class="bi bi-grid"></i> Catalogue des objets disponibles</h2>
                <p class="text-muted">Découvrez les objets proposés par les autres utilisateurs</p>
            </div>
        </div>

        <div class="row">
            <?php if (empty($produits)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Aucun objet disponible pour le moment.
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
                                <p class="text-muted small">
                                    <i class="bi bi-person"></i> Proposé par: <strong><?= htmlspecialchars($produit['proprietaire']) ?></strong>
                                </p>
                                <button class="btn btn-primary w-100" onclick='showDetails(<?= json_encode($produit) ?>)'>
                                    <i class="bi bi-eye"></i> Voir les détails
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Détails -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="detailsImage" src="" class="img-fluid rounded" alt="">
                        </div>
                        <div class="col-md-6">
                            <p><strong>Catégorie:</strong> <span id="detailsCategorie" class="badge bg-secondary"></span></p>
                            <p><strong>Prix estimatif:</strong> <span id="detailsPrix" class="text-success fw-bold"></span></p>
                            <p><strong>Propriétaire:</strong> <span id="detailsProprietaire"></span></p>
                            <p><strong>Contact:</strong> <span id="detailsEmail"></span></p>
                            <hr>
                            <p><strong>Description:</strong></p>
                            <p id="detailsDescription"></p>
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle"></i> Pour proposer un échange, contactez le propriétaire par email.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a id="contactBtn" href="" class="btn btn-primary">
                        <i class="bi bi-envelope"></i> Contacter
                    </a>
                </div>
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

        function showDetails(produit) {
            document.getElementById('detailsTitle').textContent = produit.nom;
            document.getElementById('detailsImage').src = '/uploads/' + produit.photo;
            document.getElementById('detailsCategorie').textContent = produit.categorie_nom || 'Sans catégorie';
            document.getElementById('detailsPrix').textContent = new Intl.NumberFormat('fr-MG').format(produit.prix) + ' Ar';
            document.getElementById('detailsProprietaire').textContent = produit.proprietaire;
            document.getElementById('detailsEmail').textContent = produit.proprietaire_email;
            document.getElementById('detailsDescription').textContent = produit.description;
            document.getElementById('contactBtn').href = 'mailto:' + produit.proprietaire_email + '?subject=Proposition d\'échange pour ' + produit.nom;
            
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        }
    </script>
</body>
</html>
