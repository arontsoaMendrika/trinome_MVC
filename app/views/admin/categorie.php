<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
</head>
<body>
    <h1>Liste des Catégories</h1>
    <ul>
        <?php foreach ($categories as $categorie): ?>
            <li><?php echo htmlspecialchars($categorie['nom']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>