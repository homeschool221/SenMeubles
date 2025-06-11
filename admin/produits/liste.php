<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login_admin.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "senmeubles");
$result = $conn->query("SELECT * FROM produits");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des produits</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);}
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.8rem; border: 1px solid #ddd; text-align: left; }
        th { background: #007bff; color: #fff; }
        a.btn { padding: 0.4rem 1rem; border-radius: 4px; color: #fff; text-decoration: none; }
        .edit { background: #28a745; }
        .delete { background: #dc3545; }
        .add { background: #007bff; margin-bottom: 1rem; display: inline-block;}
        .prod-img { max-width: 80px; max-height: 80px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des produits</h2>
        <a href="ajouter.php" class="btn add">Ajouter un produit</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>
    <?php if (!empty($row['image_url'])): ?>
        <img src="../../uploads/<?= htmlspecialchars($row['image_url']) ?>" class="prod-img" alt="Image produit">
    <?php else: ?>
        <span style="color:#888;">Aucune image</span>
    <?php endif; ?>
</td>
                <td><?= htmlspecialchars($row['nom']) ?></td>
                <td><?= $row['prix'] ?></td>
                <td>
                    <a href="modifier.php?id=<?= $row['id'] ?>" class="btn edit">Modifier</a>
                    <a href="supprimer.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="../dashboard.php" class="btn" style="background:#6c757d;">Retour Dashboard</a>
    </div>
</body>
</html>