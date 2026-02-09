<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = 'Connexion - Takalo';
ob_start();
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-box-seam text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3 fw-bold">Connexion</h2>
                        <p class="text-muted">Accédez à votre compte Takalo</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/login">
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>Adresse email
                            </label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                   placeholder="votre@email.com" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="motdepasse" class="form-label">
                                <i class="bi bi-lock me-1"></i>Mot de passe
                            </label>
                            <input type="password" class="form-control form-control-lg" id="motdepasse" 
                                   name="motdepasse" placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>

                        <div class="text-center">
                            <p class="text-muted">
                                Pas encore de compte ? 
                                <a href="/register" class="text-decoration-none fw-semibold">S'inscrire</a>
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
