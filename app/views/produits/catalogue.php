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

        <!-- Barre de recherche -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par titre...">
            </div>
            <div class="col-md-4">
                <select id="categorySelect" class="form-select">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= htmlspecialchars($categorie['nom']) ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button id="clearSearch" class="btn btn-secondary w-100">
                    <i class="bi bi-x-circle"></i> Effacer
                </button>
            </div>
        </div>

        <div class="row" id="productsContainer">
            <?php if (empty($produits)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Aucun objet disponible pour le moment.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($produits as $produit): ?>
                    <div class="col-md-4 mb-4 product-card" data-aos="fade-up" data-title="<?= htmlspecialchars(strtolower($produit['nom'])) ?>" data-category="<?= htmlspecialchars(strtolower($produit['categorie_nom'] ?? '')) ?>">
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
                            <div id="photoCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" id="carouselInner">
                                    <!-- Les photos seront ajoutées dynamiquement par JavaScript -->
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#photoCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Précédent</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#photoCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Suivant</span>
                                </button>
                            </div>
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
            document.getElementById('detailsCategorie').textContent = produit.categorie_nom || 'Sans catégorie';
            document.getElementById('detailsPrix').textContent = new Intl.NumberFormat('fr-MG').format(produit.prix) + ' Ar';
            document.getElementById('detailsProprietaire').textContent = produit.proprietaire;
            document.getElementById('detailsEmail').textContent = produit.proprietaire_email;
            document.getElementById('detailsDescription').textContent = produit.description;
            document.getElementById('contactBtn').href = 'mailto:' + produit.proprietaire_email + '?subject=Proposition d\'échange pour ' + produit.nom;
            
            // Gérer les photos multiples
            const carouselInner = document.getElementById('carouselInner');
            carouselInner.innerHTML = ''; // Vider le carousel
            
            if (produit.photos && produit.photos.length > 0) {
                produit.photos.forEach((photo, index) => {
                    const carouselItem = document.createElement('div');
                    carouselItem.className = 'carousel-item' + (index === 0 ? ' active' : '');
                    
                    const img = document.createElement('img');
                    img.src = '/uploads/' + photo.photo;
                    img.className = 'd-block w-100 img-fluid rounded';
                    img.alt = produit.nom + ' - Photo ' + (index + 1);
                    img.onerror = function() {
                        this.src = 'https://via.placeholder.com/400x300?text=Photo+indisponible';
                    };
                    
                    carouselItem.appendChild(img);
                    carouselInner.appendChild(carouselItem);
                });
                
                // Afficher les contrôles du carousel seulement s'il y a plusieurs photos
                const carouselControls = document.querySelectorAll('#photoCarousel .carousel-control-prev, #photoCarousel .carousel-control-next');
                carouselControls.forEach(control => {
                    control.style.display = produit.photos.length > 1 ? 'block' : 'none';
                });
            } else {
                // Photo par défaut si aucune photo
                const carouselItem = document.createElement('div');
                carouselItem.className = 'carousel-item active';
                
                const img = document.createElement('img');
                img.src = '/uploads/default.jpg';
                img.className = 'd-block w-100 img-fluid rounded';
                img.alt = produit.nom;
                img.onerror = function() {
                    this.src = 'https://via.placeholder.com/400x300?text=Photo+indisponible';
                };
                
                carouselItem.appendChild(img);
                carouselInner.appendChild(carouselItem);
                
                // Masquer les contrôles du carousel
                const carouselControls = document.querySelectorAll('#photoCarousel .carousel-control-prev, #photoCarousel .carousel-control-next');
                carouselControls.forEach(control => {
                    control.style.display = 'none';
                });
            }
            
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        }

        // Fonction de recherche
        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const selectedCategory = document.getElementById('categorySelect').value.toLowerCase().trim();
            const productCards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            productCards.forEach(card => {
                const title = card.dataset.title || '';
                const category = card.dataset.category || '';
                
                const matchesSearch = title.includes(searchTerm);
                const matchesCategory = selectedCategory === '' || category === selectedCategory;
                
                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Afficher un message si aucun produit ne correspond
            const noResultsMsg = document.getElementById('noResultsMsg');
            if (visibleCount === 0 && productCards.length > 0) {
                if (!noResultsMsg) {
                    const msg = document.createElement('div');
                    msg.id = 'noResultsMsg';
                    msg.className = 'col-12';
                    msg.innerHTML = '<div class="alert alert-warning text-center"><i class="bi bi-search"></i> Aucun produit ne correspond à votre recherche.</div>';
                    document.getElementById('productsContainer').appendChild(msg);
                }
            } else if (noResultsMsg) {
                noResultsMsg.remove();
            }
        }

        // Événements pour la recherche
        document.getElementById('searchInput').addEventListener('input', filterProducts);
        document.getElementById('categorySelect').addEventListener('change', filterProducts);
        document.getElementById('clearSearch').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categorySelect').value = '';
            filterProducts();
        });
    </script>
</body>
</html>
