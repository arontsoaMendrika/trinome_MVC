<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = 'Mes Objets - Takalo';
ob_start();
?>

<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-2">
                    <i class="bi bi-collection me-2"></i>Mes Objets
                </h1>
                <p class="lead mb-0">Gérez vos objets à échanger</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="/mes-objets/nouveau" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter un objet
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($produits)): ?>
        <div class="empty-state">
            <i class="bi bi-box-seam d-block"></i>
            <h3 class="text-muted">Aucun objet pour le moment</h3>
            <p class="text-muted mb-4">Commencez par ajouter votre premier objet à échanger !</p>
            <a href="/mes-objets/nouveau" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Ajouter mon premier objet
            </a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if ($produit['photo']): ?>
                            <img src="/uploads/<?= htmlspecialchars($produit['photo']) ?>" 
                                 class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($produit['nom']) ?></h5>
                                <span class="price-badge"><?= number_format($produit['prix'], 0, ',', ' ') ?> Ar</span>
                            </div>
                            
                            <?php if ($produit['categorie_nom']): ?>
                                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($produit['categorie_nom']) ?></span>
                            <?php endif; ?>
                            
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars(substr($produit['description'], 0, 100)) ?>
                                <?= strlen($produit['description']) > 100 ? '...' : '' ?>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2">
                                <a href="/mes-objets/<?= $produit['id'] ?>/modifier" class="btn btn-outline-primary flex-grow-1">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </a>
                                <button type="button" class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal<?= $produit['id'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal de confirmation de suppression -->
                    <div class="modal fade" id="deleteModal<?= $produit['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title">Confirmer la suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Êtes-vous sûr de vouloir supprimer <strong><?= htmlspecialchars($produit['nom']) ?></strong> ?</p>
                                    <p class="text-muted small mb-0">Cette action est irréversible.</p>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <form action="/mes-objets/<?= $produit['id'] ?>/supprimer" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
