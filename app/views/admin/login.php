<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-Takalo</title>
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/vendor/aos/aos.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .btn-admin {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            color: white;
        }
        .btn-admin:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            color: white;
        }
        .default-credentials {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card" data-aos="fade-up">
                    <div class="login-header">
                        <h2><i class="bi bi-shield-lock"></i> Admin</h2>
                        <p class="mb-0">E-Takalo - Backoffice</p>
                    </div>
                    <div class="p-4">
                        <h4 class="mb-3 text-center">Connexion Administrateur</h4>

                        <div class="default-credentials mb-3">
                            <i class="bi bi-info-circle"></i> <strong>Identifiants par défaut :</strong><br>
                            Email : <code><?= htmlspecialchars($default_email) ?></code><br>
                            Mot de passe : <code><?= htmlspecialchars($default_password) ?></code>
                        </div>
                        
                        <?php if (isset($_SESSION['admin_error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['admin_error']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['admin_error']); ?>
                        <?php endif; ?>
                        
                        <form action="/admin/login" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= htmlspecialchars($default_email) ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           value="<?= htmlspecialchars($default_password) ?>" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-admin w-100 py-2 mb-3">
                                <i class="bi bi-box-arrow-in-right"></i> Se connecter
                            </button>
                            
                            <div class="text-center">
                                <a href="/" class="text-muted"><i class="bi bi-arrow-left"></i> Retour au site</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/aos/aos.js"></script>
    <script>AOS.init({ duration: 1000, once: true });</script>
</body>
</html>
