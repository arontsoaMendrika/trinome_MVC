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
                        <i class="bi bi-box-arrow-in-right text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3">Connexion</h2>
                        <p class="text-muted">Accédez à votre espace Takalo</p>
                    </div>

                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> <?= $error ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="/login">
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" 
                                       placeholder="votre@email.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="motdepasse" class="form-label">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="motdepasse" name="motdepasse" 
                                       placeholder="Votre mot de passe" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </button>
                    </form>

                    <hr class="my-4">

                    <p class="text-center mb-0">
                        Pas encore de compte? <a href="/register" class="text-decoration-none">S'inscrire</a>
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
