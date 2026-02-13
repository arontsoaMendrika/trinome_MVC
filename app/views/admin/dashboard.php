<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Takalo</title>
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/vendor/aos/aos.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .navbar-admin {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        .stat-number { font-size: 2rem; font-weight: bold; }
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
                <a href="/admin" class="sidebar-link active">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="/admin/categories" class="sidebar-link">
                    <i class="bi bi-tags"></i> Catégories
                </a>
                <a href="/admin/statistics" class="sidebar-link">
                    <i class="bi bi-bar-chart-line"></i> Statistiques
                </a>
                <hr class="text-light">
                <a href="/" class="sidebar-link">
                    <i class="bi bi-arrow-left"></i> Retour au site
                </a>
            </div>

            <!-- Main content -->
            <div class="col-md-10 py-4">
                <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="0">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div>
                                    <div class="stat-number text-primary"><?= (int)$nbUsers ?></div>
                                    <div class="text-muted">Utilisateurs</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                                    <i class="bi bi-arrow-left-right"></i>
                                </div>
                                <div>
                                    <div class="stat-number text-danger"><?= (int)$nbEchanges ?></div>
                                    <div class="text-muted">Échanges</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                    <i class="bi bi-tags"></i>
                                </div>
                                <div>
                                    <div class="stat-number text-info"><?= (int)$nbCategories ?></div>
                                    <div class="text-muted">Catégories</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stat-icon me-3" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <div>
                                    <div class="stat-number text-success"><?= (int)$nbProduits ?></div>
                                    <div class="text-muted">Produits</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick links -->
                <div class="row">
                    <div class="col-md-6 mb-3" data-aos="fade-up">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5><i class="bi bi-tags text-primary"></i> Gestion des catégories</h5>
                                <p class="text-muted">Ajouter, modifier et supprimer les catégories de produits.</p>
                                <a href="/admin/categories" class="btn btn-primary">
                                    <i class="bi bi-arrow-right"></i> Gérer les catégories
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5><i class="bi bi-bar-chart-line text-success"></i> Statistiques détaillées</h5>
                                <p class="text-muted">Voir les statistiques des utilisateurs et des échanges.</p>
                                <a href="/admin/statistics" class="btn btn-success">
                                    <i class="bi bi-arrow-right"></i> Voir les statistiques
                                </a>
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
