<?php
include 'config.php'; include 'header.php';
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); exit;
}
$user = $_SESSION['user'];
if ($user['rôle'] === 'admin') {
    $stmt = $pdo->query("SELECT c.*, u.nom FROM commandes c JOIN utilisateurs u ON c.id_utilisateur = u.id ORDER BY c.id DESC");
} else {
    $stmt = $pdo->prepare("SELECT * FROM commandes WHERE id_utilisateur = ? ORDER BY id DESC");
    $stmt->execute([$user['id']]);
}
$commandes = $stmt->fetchAll();
?>
<h1>Mes Commandes</h1>
<table class="table">
    <thead>
        <tr>
            <?php if ($user['rôle'] === 'admin'): ?><th>Client</th><?php endif; ?>
            <th>Date</th><th>Statut</th><th>Détails</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($commandes as $c): ?>
        <tr>
            <?php if ($user['rôle'] === 'admin'): ?><td><?= htmlspecialchars($c['nom']) ?></td><?php endif; ?>
            <td><?= htmlspecialchars($c['date_commande']) ?></td>
            <td><?= htmlspecialchars($c['statut']) ?></td>
            <td><a href="commande_details.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-info">Voir</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>