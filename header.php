<?php
if (!isset($_SESSION)) session_start();
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['rôle'] === 'admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SenMeubles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">SenMeubles</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="boutique.php">Boutique</a></li>
                <li class="nav-item"><a class="nav-link" href="panier.php">Panier</a></li>
                <?php if ($isAdmin): ?>
                    <li class="nav-item"><a class="nav-link" href="/admin/produits.php">Admin</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Inscription</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="commandes.php">Mes commandes</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion (<?= htmlspecialchars($_SESSION['user']['nom']) ?>)</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">