<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start(); 
?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">
            <i class="bi bi-arrow-left-right"></i> Takalo
        </h1>
        <p class="lead mb-4">La plateforme de troc et d'échange à Madagascar</p>
        <?php if (empty($_SESSION['logged_in'])): ?>
        <div class="d-flex justify-content-center gap-3">
            <a href="/register" class="btn btn-light btn-lg">
                <i class="bi bi-person-plus"></i> S'inscrire
            </a>
            <a href="/login" class="btn btn-outline-light btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </a>
        </div>
        <?php else: ?>
        <a href="/mes-produits" class="btn btn-light btn-lg">
            <i class="bi bi-box-seam"></i> Gérer mes objets
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="container py-5">
    <?php if(!empty($message)): ?>
    <div class="alert alert-success text-center">
        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <!-- Features -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Publiez vos objets</h4>
                    <p class="text-muted">Ajoutez photos, description et prix estimatif pour vos objets à échanger.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-search text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Trouvez des échanges</h4>
                    <p class="text-muted">Parcourez les annonces et trouvez l'objet parfait pour un échange.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4">
                <div class="card-body">
                    <i class="bi bi-arrow-left-right text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Échangez en toute confiance</h4>
                    <p class="text-muted">Contactez les autres membres et réalisez vos échanges en toute sécurité.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <?php if (empty($_SESSION['logged_in'])): ?>
    <div class="card bg-light border-0">
        <div class="card-body text-center py-5">
            <h3>Prêt à commencer?</h3>
            <p class="text-muted mb-4">Rejoignez la communauté Takalo et commencez à échanger dès maintenant!</p>
            <a href="/register" class="btn btn-primary btn-lg">
                <i class="bi bi-rocket-takeoff"></i> Créer mon compte gratuitement
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/layouts/main.php';
?>