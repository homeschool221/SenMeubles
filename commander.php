<?php
include 'config.php'; include 'header.php';
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
if (empty($_SESSION['panier'])) {
    echo "<p>Votre panier est vide.</p>";
    include 'footer.php';
    exit;
}
$user_id = $_SESSION['user']['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Création commande
    $pdo->beginTransaction();
    $pdo->prepare("INSERT INTO commandes (id_utilisateur, date_commande, statut) VALUES (?, NOW(), 'en attente')")
        ->execute([$user_id]);
    $id_commande = $pdo->lastInsertId();
    $insert = $pdo->prepare("INSERT INTO commande_produits (id_commande, id_produit, quantité) VALUES (?, ?, ?)");
    foreach ($_SESSION['panier'] as $id_prod => $qte) {
        $insert->execute([$id_commande, $id_prod, $qte]);
    }
    $pdo->commit();
    $_SESSION['panier'] = [];
    echo '<div class="alert alert-success">Commande enregistrée !</div>
    <a href="commande_details.php?id='.$id_commande.'" class="btn btn-primary">Voir ma commande</a>';
    include 'footer.php';
    exit;
}
?>
<h1>Finaliser la commande</h1>
<form method="post">
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['nom']) ?>" disabled>
    </div>
    <button type="submit" class="btn btn-success">Confirmer la commande</button>
</form>
<?php include 'footer.php'; ?>