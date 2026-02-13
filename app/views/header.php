<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Takalo-Takalo'; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Takalo-Takalo</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item"><a class="nav-link" href="#">Objets</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Mes Échanges</a></li>
                    <li class="nav-item"><a class="btn btn-aesthetic btn-sm" href="#">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>