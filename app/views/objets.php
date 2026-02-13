<div class="container my-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="search-container d-flex align-items-center">
                <i class="bi bi-search me-2"></i>
                <input type="text" class="form-control search-input" placeholder="Rechercher un objet...">
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($objets)): ?>
            <?php foreach ($objets as $objet): ?>
                <div class="col-md-4">
                    <div class="obj-card card h-100">
                        <div class="obj-img-placeholder">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($objet['titre'] ?? 'Titre') ?></h5>
                            <p class="card-text"><?= htmlspecialchars($objet['description'] ?? 'Description') ?></p>
                            <a href="/objet/<?= $objet['id'] ?>" class="btn btn-aesthetic">Voir détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Aucun objet disponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>