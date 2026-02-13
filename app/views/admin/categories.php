<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories - E-Takalo Admin</title>
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
        .table th { background: #f8f9fa; }
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
                <a href="/admin/categories" class="sidebar-link active">
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="bi bi-tags"></i> Gestion des Catégories</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-circle"></i> Ajouter une catégorie
                    </button>
                </div>

                <!-- Messages -->
                <?php if (isset($_SESSION['admin_success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($_SESSION['admin_success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['admin_success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['admin_error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($_SESSION['admin_error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['admin_error']); ?>
                <?php endif; ?>

                <!-- Table des catégories -->
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body">
                        <?php if (empty($categories)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                <p class="mt-2">Aucune catégorie trouvée</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="bi bi-plus-circle"></i> Ajouter la première catégorie
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th width="80">ID</th>
                                            <th>Nom</th>
                                            <th width="200" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $cat): ?>
                                            <tr>
                                                <td><span class="badge bg-secondary"><?= (int)$cat['id'] ?></span></td>
                                                <td class="fw-semibold"><?= htmlspecialchars($cat['nom']) ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-warning me-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editModal" 
                                                            onclick="fillEditForm(<?= (int)$cat['id'] ?>, '<?= htmlspecialchars($cat['nom'], ENT_QUOTES) ?>')">
                                                        <i class="bi bi-pencil"></i> Modifier
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal"
                                                            onclick="fillDeleteForm(<?= (int)$cat['id'] ?>, '<?= htmlspecialchars($cat['nom'], ENT_QUOTES) ?>')">
                                                        <i class="bi bi-trash"></i> Supprimer
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted mt-2">
                                <i class="bi bi-info-circle"></i> Total : <?= count($categories) ?> catégorie(s)
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajouter -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/categories/add" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Ajouter une catégorie</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addNom" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control" id="addNom" name="nom" required 
                                   placeholder="Ex: Électronique, Vêtements...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modifier -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/categories/update" method="POST">
                    <input type="hidden" id="editId" name="id">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="bi bi-pencil"></i> Modifier la catégorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNom" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control" id="editNom" name="nom" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Supprimer -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-trash"></i> Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer la catégorie <strong id="deleteNom"></strong> ?</p>
                    <p class="text-muted small">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a id="deleteLink" href="#" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/aos/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
        
        function fillEditForm(id, nom) {
            document.getElementById('editId').value = id;
            document.getElementById('editNom').value = nom;
        }

        function fillDeleteForm(id, nom) {
            document.getElementById('deleteNom').textContent = nom;
            document.getElementById('deleteLink').href = '/admin/categories/delete/' + id;
        }
    </script>
</body>
</html>
