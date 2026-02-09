<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start(); 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3">Inscription</h2>
                        <p class="text-muted">Rejoignez la communauté Takalo</p>
                    </div>

                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> <?= $error ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="/register">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="nom" name="nom" 
                                       value="<?= htmlspecialchars($old['nom'] ?? '') ?>" 
                                       placeholder="Ex: Rakoto Andrianina" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" 
                                       placeholder="votre@email.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="motdepasse" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="motdepasse" name="motdepasse" 
                                       placeholder="Minimum 6 caractères" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_motdepasse" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="confirm_motdepasse" 
                                       name="confirm_motdepasse" placeholder="Confirmez votre mot de passe" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-person-plus"></i> S'inscrire
                        </button>
                    </form>

                    <hr class="my-4">

                    <p class="text-center mb-0">
                        Déjà un compte? <a href="/login" class="text-decoration-none">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>
