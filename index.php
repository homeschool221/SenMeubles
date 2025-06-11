<?php 
include 'config.php'; 
include 'header.php';

// Récupération des 8 derniers produits pour le catalogue d'accueil
$stmt = $pdo->query("SELECT * FROM produits ORDER BY id DESC LIMIT 8");
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - SenMeubles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .catalogue-section { background: #f8f9fa; padding: 40px 0; }
        .card-img-top { max-height: 220px; object-fit: cover; }
        .btn-catalogue { margin-top: 30px; }
        .hero { background: #007bff; color: #fff; padding: 60px 0 40px 0; text-align: center; }
        .hero h1 { font-size: 2.8rem; margin-bottom: 20px; }
        .hero p { font-size: 1.3rem; }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Bienvenue sur SenMeubles</h1>
        <p>Découvrez notre sélection de meubles modernes et élégants pour votre intérieur.</p>
        <a href="boutique.php" class="btn btn-light btn-lg mt-3">Voir tout le catalogue</a>
    </div>

    <section class="catalogue-section">
        <div class="container">
            <h2 class="mb-4 text-center">Catalogue de produits</h2>
            <div class="row">
                <?php foreach ($produits as $p): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="uploads/<?= htmlspecialchars($p['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nom']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($p['nom']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                                <p class="card-text fw-bold mb-2"><?= number_format($p['prix'], 2) ?> FCFA</p>
                                <a href="boutique.php" class="btn btn-primary mt-auto">Voir la boutique</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center btn-catalogue">
                <a href="boutique.php" class="btn btn-success btn-lg">Voir tout le catalogue</a>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>