<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Takalo - Plateforme d'échange d'objets</title>
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/vendor/aos/aos.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 15px;
        }
        .btn-custom {
            background: white;
            color: #667eea;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            color: #764ba2;
        }
        .stats-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            color: white;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-3 fw-bold mb-4">
                        <i class="bi bi-arrow-left-right"></i> E-Takalo
                    </h1>
                    <p class="lead mb-4">
                        La plateforme malgache d'échange d'objets entre particuliers. 
                        Donnez une seconde vie à vos objets tout en obtenant ce dont vous avez besoin !
                    </p>
                    
                    <div class="d-flex gap-3 mb-5">
                        <a href="/inscription" class="btn btn-custom">
                            <i class="bi bi-person-plus"></i> Commencer maintenant
                        </a>
                        <a href="/login" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </a>
                    </div>

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stats-card" data-aos="fade-up" data-aos-delay="100">
                                <h3 class="fw-bold">1000+</h3>
                                <p class="mb-0">Utilisateurs</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-card" data-aos="fade-up" data-aos-delay="200">
                                <h3 class="fw-bold">5000+</h3>
                                <p class="mb-0">Objets</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-card" data-aos="fade-up" data-aos-delay="300">
                                <h3 class="fw-bold">3000+</h3>
                                <p class="mb-0">Échanges</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="row">
                        <div class="col-12">
                            <div class="feature-card" data-aos="zoom-in" data-aos-delay="100">
                                <div class="feature-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                                <h3 class="text-dark fw-bold">Mettez vos objets en ligne</h3>
                                <p class="text-muted mb-0">
                                    Ajoutez facilement vos objets avec photos, descriptions et prix estimatif
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="feature-card" data-aos="zoom-in" data-aos-delay="200">
                                <div class="feature-icon">
                                    <i class="bi bi-grid-3x3"></i>
                                </div>
                                <h3 class="text-dark fw-bold">Explorez le catalogue</h3>
                                <p class="text-muted mb-0">
                                    Découvrez des milliers d'objets proposés par d'autres utilisateurs
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="feature-card" data-aos="zoom-in" data-aos-delay="300">
                                <div class="feature-icon">
                                    <i class="bi bi-arrow-left-right"></i>
                                </div>
                                <h3 class="text-dark fw-bold">Échangez simplement</h3>
                                <p class="text-muted mb-0">
                                    Contactez les propriétaires et proposez des échanges équitables
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/aos/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
