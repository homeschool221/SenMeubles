<?php
include 'config.php'; 
include 'header.php';

// Traitement du filtre et de la recherche
$where = [];
$params = [];

if (!empty($_GET['q'])) {
    $where[] = "nom LIKE :q";
    $params['q'] = '%' . $_GET['q'] . '%';
}
if (!empty($_GET['prix_min'])) {
    $where[] = "prix >= :prix_min";
    $params['prix_min'] = $_GET['prix_min'];
}
if (!empty($_GET['prix_max'])) {
    $where[] = "prix <= :prix_max";
    $params['prix_max'] = $_GET['prix_max'];
}

$sql = "SELECT * FROM produits";
if ($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll();
?>
<h1 class="mb-4 text-center">Boutique</h1>

<!-- Formulaire de recherche et filtre -->
<form method="get" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control" placeholder="Rechercher un produit..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
    </div>
    <div class="col-md-2">
        <input type="number" name="prix_min" class="form-control" placeholder="Prix min" value="<?= isset($_GET['prix_min']) ? htmlspecialchars($_GET['prix_min']) : '' ?>">
    </div>
    <div class="col-md-2">
        <input type="number" name="prix_max" class="form-control" placeholder="Prix max" value="<?= isset($_GET['prix_max']) ? htmlspecialchars($_GET['prix_max']) : '' ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
    </div>
    <div class="col-md-2">
        <a href="boutique.php" class="btn btn-secondary w-100">Réinitialiser</a>
    </div>
</form>

<div class="row">
    <?php foreach ($produits as $p): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="uploads/<?= htmlspecialchars($p['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nom']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($p['nom']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                    <p class="card-text fw-bold"><?= number_format($p['prix'], 2) ?> FCFA</p>
                    <form method="post" action="panier.php">
                        <input type="hidden" name="id_produit" value="<?= $p['id'] ?>">
                        <input type="number" name="quantite" value="1" min="1" class="form-control mb-2" style="width: 90px">
                        <button type="submit" class="btn btn-success w-100">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include 'footer.php'; ?>