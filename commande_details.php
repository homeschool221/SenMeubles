<?php
include 'config.php'; include 'header.php';
if (!isset($_GET['id'])) {
    echo "<p>Commande introuvable.</p>";
    include 'footer.php'; exit;
}
$id_commande = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
$stmt->execute([$id_commande]);
$commande = $stmt->fetch();
if (!$commande) {
    echo "<p>Commande introuvable.</p>";
    include 'footer.php'; exit;
}
$stmt = $pdo->prepare("SELECT p.nom, p.prix, cp.quantité FROM commande_produits cp
    JOIN produits p ON cp.id_produit = p.id WHERE cp.id_commande = ?");
$stmt->execute([$id_commande]);
$produits = $stmt->fetchAll();
?>
<h1>Détails de la commande #<?= $id_commande ?></h1>
<p><strong>Date :</strong> <?= htmlspecialchars($commande['date_commande']) ?></p>
<p><strong>Statut :</strong> <?= htmlspecialchars($commande['statut']) ?></p>
<table class="table">
    <thead>
        <tr><th>Produit</th><th>Prix</th><th>Quantité</th><th>Sous-total</th></tr>
    </thead>
    <tbody>
        <?php $total = 0;
        foreach ($produits as $p):
            $st = $p['prix'] * $p['quantité']; $total += $st;
        ?>
        <tr>
            <td><?= htmlspecialchars($p['nom']) ?></td>
            <td><?= number_format($p['prix'], 2) ?> FCFA</td>
            <td><?= $p['quantité'] ?></td>
            <td><?= number_format($st, 2) ?> FCFA</td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="text-end">Total</td>
            <td><strong><?= number_format($total, 2) ?> FCFA</strong></td>
        </tr>
    </tbody>
</table>
<?php include 'footer.php'; ?>