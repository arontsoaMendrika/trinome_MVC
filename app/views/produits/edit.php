<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = 'Modifier l\'objet - Takalo';
ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="/mes-objets" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Retour à mes objets
                </a>
            </div>

            <div class="card shadow-lg">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil text-primary me-2"></i>Modifier l'objet
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/mes-objets/<?= $produit['id'] ?>/modifier" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold">
                                <i class="bi bi-tag me-1"></i>Titre de l'objet <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="nom" name="nom" 
                                   placeholder="Ex: iPhone 12 Pro Max" 
                                   value="<?= htmlspecialchars($produit['nom']) ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph me-1"></i>Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="Décrivez votre objet en détail..." 
                                      required><?= htmlspecialchars($produit['description']) ?></textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="prix" class="form-label fw-semibold">
                                    <i class="bi bi-currency-dollar me-1"></i>Prix estimatif (Ar) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-lg" id="prix" name="prix" 
                                           placeholder="0" min="0" step="100"
                                           value="<?= htmlspecialchars($produit['prix']) ?>" required>
                                    <span class="input-group-text">Ar</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="categorie_id" class="form-label fw-semibold">
                                    <i class="bi bi-grid me-1"></i>Catégorie
                                </label>
                                <select class="form-select form-select-lg" id="categorie_id" name="categorie_id">
                                    <option value="">-- Sélectionner --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" 
                                            <?= $produit['categorie_id'] == $cat['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['nom']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php if ($produit['photo']): ?>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Photo actuelle</label>
                                <div class="border rounded p-2 text-center bg-light">
                                    <img src="/uploads/<?= htmlspecialchars($produit['photo']) ?>" 
                                         alt="Photo actuelle" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <label for="photo" class="form-label fw-semibold">
                                <i class="bi bi-camera me-1"></i><?= $produit['photo'] ? 'Changer la photo' : 'Ajouter une photo' ?>
                            </label>
                            <input type="file" class="form-control form-control-lg" id="photo" name="photo" 
                                   accept="image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">Formats acceptés : JPG, PNG, GIF, WEBP. Taille max : 5 Mo</div>
                        </div>

                        <div id="imagePreview" class="mb-4" style="display: none;">
                            <label class="form-label fw-semibold">Nouvelle photo</label>
                            <div class="border rounded p-2 text-center bg-light">
                                <img id="previewImg" src="" alt="Aperçu" class="img-fluid rounded" style="max-height: 250px;">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="/mes-objets" class="btn btn-outline-secondary btn-lg">Annuler</a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
