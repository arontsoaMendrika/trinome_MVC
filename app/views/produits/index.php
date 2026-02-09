<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start(); 
?>

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-box-seam"></i> Mes Objets</h2>
            <p class="text-muted mb-0">Gérez vos objets à échanger</p>
        </div>
        <a href="/mes-produits/ajouter" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Ajouter un objet
        </a>
    </div>

    <?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (empty($produits)): ?>
    <!-- Empty State -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3">Aucun objet pour le moment</h4>
            <p class="text-muted">Commencez par ajouter votre premier objet à échanger!</p>
            <a href="/mes-produits/ajouter" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Ajouter mon premier objet
            </a>
        </div>
    </div>
    <?php else: ?>
    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($produits as $produit): ?>
        <div class="col">
            <div class="card h-100">
                <?php 
                $photos = explode(',', $produit['photo']);
                $firstPhoto = trim($photos[0]);
                ?>
                <img src="/uploads/<?= htmlspecialchars($firstPhoto) ?>" 
                     class="card-img-top product-image" 
                     alt="<?= htmlspecialchars($produit['nom']) ?>"
                     onerror="this.src='https://via.placeholder.com/300x200?text=Image+non+disponible'">
                
                <?php if (count($photos) > 1): ?>
                <span class="position-absolute top-0 end-0 m-2 badge bg-dark">
                    <i class="bi bi-images"></i> <?= count($photos) ?>
                </span>
                <?php endif; ?>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge badge-category"><?= htmlspecialchars($produit['categorie_nom'] ?? 'Non catégorisé') ?></span>
                    </div>
                    <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                    <p class="card-text text-muted small">
                        <?= htmlspecialchars(substr($produit['description'], 0, 100)) ?>
                        <?= strlen($produit['description']) > 100 ? '...' : '' ?>
                    </p>
                    <p class="price-tag mb-0">
                        <?= number_format($produit['prix'], 0, ',', ' ') ?> Ar
                    </p>
                </div>
                
                <div class="card-footer bg-white border-0">
                    <div class="btn-group w-100">
                        <a href="/mes-produits/modifier/<?= $produit['id'] ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                onclick="confirmDelete(<?= $produit['id'] ?>, '<?= htmlspecialchars(addslashes($produit['nom'])) ?>')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger"></i> Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer <strong id="deleteItemName"></strong>?</p>
                <p class="text-muted small">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteForm').action = '/mes-produits/supprimer/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
