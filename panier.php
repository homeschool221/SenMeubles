<?php
include 'config.php'; include 'header.php';
// Initialisation panier en session
if (!isset($_SESSION['panier'])) $_SESSION['panier'] = [];
// Ajout produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_produit'])) {
    $id = (int)$_POST['id_produit'];
    $qte = max(1, (int)$_POST['quantite']);
    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] += $qte;
    } else {
        $_SESSION['panier'][$id] = $qte;
    }
    echo '<div class="alert alert-success">Produit ajouté au panier !</div>';
}
// Suppression produit
if (isset($_GET['del'])) {
    unset($_SESSION['panier'][(int)$_GET['del']]);
    echo '<div class="alert alert-warning">Produit retiré du panier.</div>';
}
// Affichage panier
$ids = array_keys($_SESSION['panier']);
$produits = [];
$total = 0;
if ($ids) {
    $in = implode(',', array_map('intval', $ids));
    $stmt = $pdo->query("SELECT * FROM produits WHERE id IN ($in)");
    $produits = $stmt->fetchAll();
}
?>
<h1>Mon Panier</h1>
<?php if (!$produits): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produit</th><th>Prix</th><th>Quantité</th><th>Sous-total</th><th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $p):
            $qte = $_SESSION['panier'][$p['id']];
            $st = $p['prix'] * $qte;
            $total += $st;
        ?>
        <tr>
            <td><?= htmlspecialchars($p['nom']) ?></td>
            <td><?= number_format($p['prix'], 2) ?> FCFA</td>
            <td><?= $qte ?></td>
            <td><?= number_format($st, 2) ?> FCFA</td>
            <td><a href="?del=<?= $p['id'] ?>" class="btn btn-sm btn-danger">Retirer</a></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="text-end">Total</td>
            <td colspan="2"><strong><?= number_format($total, 2) ?> FCFA</strong></td>
        </tr>
    </tbody>
</table>
<a href="commander.php" class="btn btn-primary">Commander</a>
<?php endif; ?>
<?php include 'footer.php'; ?>