<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login_admin.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "senmeubles");

if (!isset($_GET["id"])) {
    header("Location: liste.php");
    exit;
}

$id = intval($_GET["id"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prix = $_POST["prix"];
    $stmt = $conn->prepare("UPDATE produits SET nom=?, prix=? WHERE id=?");
    $stmt->bind_param("sdi", $nom, $prix, $id);
    if ($stmt->execute()) {
        header("Location: liste.php");
        exit;
    } else {
        $error = "Erreur : " . $stmt->error;
    }
    $stmt->close();
} else {
    $stmt = $conn->prepare("SELECT nom, prix FROM produits WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nom, $prix);
    if (!$stmt->fetch()) {
        header("Location: liste.php");
        exit;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);}
        input, button { width: 100%; padding: 0.8rem; margin-bottom: 1.2rem; border-radius: 4px; border: 1px solid #ddd; font-size: 1rem;}
        button { background: #28a745; color: #fff; border: none; cursor: pointer; transition: background 0.2s;}
        button:hover { background: #218838; }
        .error { color: #dc3545; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier un produit</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
            <input type="number" step="0.01" name="prix" value="<?= $prix ?>" required>
            <button type="submit">Enregistrer</button>
        </form>
        <a href="liste.php" style="display:block;text-align:center;">Retour à la liste</a>
    </div>
</body>
</html>
