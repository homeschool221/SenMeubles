<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login_admin.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "senmeubles");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prix = $_POST["prix"];
    $image = null;

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $targetDir = "../../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $filename = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $filename;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowed)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image = $filename;
            } else {
                $error = "Erreur lors de l'upload de l'image.";
            }
        } else {
            $error = "Format d'image non autorisé.";
        }
    }

    if (!isset($error)) {
        // Correction ici : la colonne s'appelle image_url dans la table produits
        $stmt = $conn->prepare("INSERT INTO produits (nom, prix, image_url) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erreur SQL: " . $conn->error);
        }
        $stmt->bind_param("sds", $nom, $prix, $image);
        if ($stmt->execute()) {
            header("Location: liste.php");
            exit;
        } else {
            $error = "Erreur : " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);}
        input, button { width: 100%; padding: 0.8rem; margin-bottom: 1.2rem; border-radius: 4px; border: 1px solid #ddd; font-size: 1rem;}
        button { background: #007bff; color: #fff; border: none; cursor: pointer; transition: background 0.2s;}
        button:hover { background: #0056b3; }
        .error { color: #dc3545; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter un produit</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom du produit" required>
            <input type="number" step="0.01" name="prix" placeholder="Prix" required>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Ajouter</button>
        </form>
        <a href="liste.php" style="display:block;text-align:center;">Retour à la liste</a>
    </div>
</body>
</html>
