<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login_admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; }
        .container { max-width: 600px; margin: 60px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);}
        h1 { text-align: center; }
        .links { display: flex; flex-direction: column; gap: 1.2rem; margin-top: 2rem;}
        a { display: block; background: #007bff; color: #fff; text-decoration: none; padding: 1rem; border-radius: 4px; text-align: center; font-size: 1.1rem;}
        a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur le Dashboard Admin</h1>
        <div class="links">
            <a href="produits/liste.php">Gérer les produits</a>
            <a href="utilisateurs/liste.php">Gérer les utilisateurs</a>
            <a href="logout.php" style="background:#dc3545;">Déconnexion</a>
        </div>
    </div>
</body>
</html>
