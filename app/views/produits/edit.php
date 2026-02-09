<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start(); 

$photos = !empty($produit['photo']) ? explode(',', $produit['photo']) : [];
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/mes-produits">Mes Objets</a></li>
                    <li class="breadcrumb-item active">Modifier: <?= htmlspecialchars($produit['nom']) ?></li>
                </ol>
            </nav>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Modifier l'objet</h4>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> <?= $error ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="/mes-produits/modifier/<?= $produit['id'] ?>" enctype="multipart/form-data">
                        <!-- Titre -->
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">
                                <i class="bi bi-tag"></i> Titre de l'objet *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="nom" name="nom" 
                                   value="<?= htmlspecialchars($produit['nom']) ?>" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-text-paragraph"></i> Description *
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      required><?= htmlspecialchars($produit['description']) ?></textarea>
                        </div>

                        <div class="row">
                            <!-- Catégorie -->
                            <div class="col-md-6 mb-4">
                                <label for="categorie_id" class="form-label fw-bold">
                                    <i class="bi bi-folder"></i> Catégorie *
                                </label>
                                <select class="form-select" id="categorie_id" name="categorie_id" required>
                                    <option value="">-- Choisir une catégorie --</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" 
                                            <?= $produit['categorie_id'] == $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['nom']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Prix -->
                            <div class="col-md-6 mb-4">
                                <label for="prix" class="form-label fw-bold">
                                    <i class="bi bi-currency-exchange"></i> Prix estimatif (Ar) *
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="prix" name="prix" 
                                           value="<?= htmlspecialchars($produit['prix']) ?>" 
                                           min="1" step="1000" required>
                                    <span class="input-group-text">Ar</span>
                                </div>
                            </div>
                        </div>

                        <!-- Photos existantes -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-images"></i> Photos actuelles
                            </label>
                            <div class="row g-2">
                                <?php foreach ($photos as $photo): ?>
                                <?php $photo = trim($photo); if (empty($photo)) continue; ?>
                                <div class="col-6 col-md-4">
                                    <div class="card">
                                        <img src="/uploads/<?= htmlspecialchars($photo) ?>" 
                                             class="card-img-top" style="height: 120px; object-fit: cover;"
                                             onerror="this.src='https://via.placeholder.com/150?text=Image+non+disponible'">
                                        <div class="card-body p-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="delete_photos[]" value="<?= htmlspecialchars($photo) ?>" 
                                                       id="delete_<?= htmlspecialchars($photo) ?>">
                                                <label class="form-check-label text-danger small" 
                                                       for="delete_<?= htmlspecialchars($photo) ?>">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Ajouter nouvelles photos -->
                        <div class="mb-4">
                            <label for="photos" class="form-label fw-bold">
                                <i class="bi bi-plus-circle"></i> Ajouter de nouvelles photos
                            </label>
                            <input type="file" class="form-control" id="photos" name="photos[]" 
                                   accept="image/jpeg,image/png,image/gif,image/webp" multiple>
                            <div class="form-text">Formats acceptés: JPG, PNG, GIF, WebP. Max 5MB par photo.</div>
                            
                            <!-- Preview -->
                            <div id="imagePreview" class="row mt-3 g-2"></div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg"></i> Enregistrer les modifications
                            </button>
                            <a href="/mes-produits" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-lg"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('photos').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(this.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4';
            col.innerHTML = `
                <div class="card border-success">
                    <img src="${e.target.result}" class="card-img-top" style="height: 120px; object-fit: cover;">
                    <div class="card-body p-2 text-center bg-success-subtle">
                        <small class="text-success"><i class="bi bi-plus-circle"></i> Nouvelle photo ${index + 1}</small>
                    </div>
                </div>
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
