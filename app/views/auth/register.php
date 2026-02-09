<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = 'Inscription - Takalo';
$old = $old ?? [];
ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3 fw-bold">Créer un compte</h2>
                        <p class="text-muted">Rejoignez la communauté Takalo</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i><?= $success ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/register">
                        <div class="mb-3">
                            <label for="nom" class="form-label">
                                <i class="bi bi-person me-1"></i>Nom complet
                            </label>
                            <input type="text" class="form-control form-control-lg" id="nom" name="nom" 
                                   placeholder="Jean Dupont" value="<?= htmlspecialchars($old['nom'] ?? '') ?>" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>Adresse email
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                   placeholder="votre@email.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="motdepasse" class="form-label">
                                <i class="bi bi-lock me-1"></i>Mot de passe
                            </label>
                            <input type="password" class="form-control form-control-lg" id="motdepasse" 
                                   name="motdepasse" placeholder="Minimum 6 caractères" required>
                            <div class="form-text">Le mot de passe doit contenir au moins 6 caractères.</div>
                        </div>

                        <div class="mb-4">
                            <label for="motdepasse_confirm" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Confirmer le mot de passe
                            </label>
                            <input type="password" class="form-control form-control-lg" id="motdepasse_confirm" 
                                   name="motdepasse_confirm" placeholder="Répétez le mot de passe" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="bi bi-person-plus me-2"></i>S'inscrire
                        </button>

                        <div class="text-center">
                            <p class="text-muted">
                                Déjà un compte ? 
                                <a href="/login" class="text-decoration-none fw-semibold">Se connecter</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
