<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login_admin.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "senmeubles");
$result = $conn->query("SELECT * FROM utilisateurs");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des utilisateurs</h2>
        <a href="ajouter.php" class="btn add">Ajouter un utilisateur</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nom']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= isset($row['role']) ? htmlspecialchars($row['role']) : '' ?></td>
                <td>
                    <a href="modifier.php?id=<?= $row['id'] ?>" class="btn edit">Modifier</a>
                    <a href="supprimer.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="../dashboard.php" class="btn" style="background:#6c757d;">Retour Dashboard</a>
    </div>
</body>
</html>
