<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - E-Takalo Admin</title>
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/vendor/aos/aos.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .navbar-admin {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .sidebar-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }
        .stat-number { font-size: 2.5rem; font-weight: bold; }
        .stat-label { font-size: 0.95rem; color: #6c757d; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/admin">
                <i class="bi bi-shield-lock"></i> E-Takalo Admin
            </a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-light me-3">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['admin_email'] ?? 'Admin') ?>
                </span>
                <a href="/admin/logout" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-dark min-vh-100 py-4">
                <a href="/admin" class="sidebar-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="/admin/categories" class="sidebar-link">
                    <i class="bi bi-tags"></i> Catégories
                </a>
                <a href="/admin/statistics" class="sidebar-link active">
                    <i class="bi bi-bar-chart-line"></i> Statistiques
                </a>
                <hr class="text-light">
                <a href="/" class="sidebar-link">
                    <i class="bi bi-arrow-left"></i> Retour au site
                </a>
            </div>

            <!-- Main content -->
            <div class="col-md-10 py-4">
                <h2 class="mb-4"><i class="bi bi-bar-chart-line"></i> Statistiques</h2>

                <!-- Statistiques principales -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="0">
                        <div class="card stat-card h-100">
                            <div class="card-body text-center py-4">
                                <div class="stat-icon mx-auto mb-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="stat-number text-primary"><?= (int)$nbUsers ?></div>
                                <div class="stat-label">Utilisateurs inscrits</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card stat-card h-100">
                            <div class="card-body text-center py-4">
                                <div class="stat-icon mx-auto mb-3" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="bi bi-arrow-left-right"></i>
                                </div>
                                <div class="stat-number text-danger"><?= (int)$nbEchanges ?></div>
                                <div class="stat-label">Échanges effectués</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="card stat-card h-100">
                            <div class="card-body text-center py-4">
                                <div class="stat-icon mx-auto mb-3" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    <i class="bi bi-tags-fill"></i>
                                </div>
                                <div class="stat-number text-info"><?= (int)$nbCategories ?></div>
                                <div class="stat-label">Catégories</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="card stat-card h-100">
                            <div class="card-body text-center py-4">
                                <div class="stat-icon mx-auto mb-3" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                                    <i class="bi bi-box-seam-fill"></i>
                                </div>
                                <div class="stat-number text-success"><?= (int)$nbProduits ?></div>
                                <div class="stat-label">Produits</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Derniers utilisateurs inscrits -->
                    <div class="col-md-6 mb-4" data-aos="fade-up">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0"><i class="bi bi-people text-primary"></i> Derniers utilisateurs inscrits</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($recentUsers)): ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2">Aucun utilisateur inscrit</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recentUsers as $user): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($user['nom']) ?></td>
                                                        <td class="text-muted"><?= htmlspecialchars($user['email']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Derniers échanges -->
                    <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0">
                                <h5 class="mb-0"><i class="bi bi-arrow-left-right text-danger"></i> Derniers échanges</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($recentEchanges)): ?>
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mt-2">Aucun échange effectué</p>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Utilisateur</th>
                                                    <th>Produit</th>
                                                    <th>Statut</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recentEchanges as $echange): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($echange['user_nom']) ?></td>
                                                        <td><?= htmlspecialchars($echange['produit_nom']) ?></td>
                                                        <td>
                                                            <span class="badge bg-info"><?= htmlspecialchars($echange['status_nom']) ?></span>
                                                        </td>
                                                        <td class="text-muted small">
                                                            <?= date('d/m/Y', strtotime($echange['date_echange'])) ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé -->
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <h5><i class="bi bi-info-circle text-primary"></i> Résumé</h5>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-people"></i> Nombre d'utilisateurs inscrits</span>
                                        <strong class="text-primary"><?= (int)$nbUsers ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-arrow-left-right"></i> Nombre d'échanges effectués</span>
                                        <strong class="text-danger"><?= (int)$nbEchanges ?></strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-tags"></i> Nombre de catégories</span>
                                        <strong class="text-info"><?= (int)$nbCategories ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-box-seam"></i> Nombre de produits</span>
                                        <strong class="text-success"><?= (int)$nbProduits ?></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/aos/aos.js"></script>
    <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>
