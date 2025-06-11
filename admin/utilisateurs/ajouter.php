<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login_admin.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "senmeubles");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $role);
    if ($stmt->execute()) {
        header("Location: liste.php");
        exit;
    } else {
        $error = "Erreur : " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);}
        input, select, button { width: 100%; padding: 0.8rem; margin-bottom: 1.2rem; border-radius: 4px; border: 1px solid #ddd; font-size: 1rem;}
        button { background: #007bff; color: #fff; border: none; cursor: pointer; transition: background 0.2s;}
        button:hover { background: #0056b3; }
        .error { color: #dc3545; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter un utilisateur</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <select name="role" required>
                <option value="">Sélectionner un rôle</option>
                <option value="client">Client</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Ajouter</button>
        </form>
        <a href="liste.php" style="display:block;text-align:center;">Retour à la liste</a>
    </div>
</body>
</html>
