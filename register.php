<?php
include 'config.php'; include 'header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';
    $mdp2 = $_POST['mot_de_passe2'] ?? '';
    if (!$nom || !$email || !$mdp || !$mdp2) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($mdp !== $mdp2) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email déjà utilisé.";
        } else {
            $hash = password_hash($mdp, PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, rôle) VALUES (?, ?, ?, 'client')")
                ->execute([$nom, $email, $hash]);
            echo '<div class="alert alert-success">Inscription réussie ! <a href="login.php">Connectez-vous</a></div>';
            include 'footer.php'; exit;
        }
    }
}
?>
<h1>Inscription</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<form method="post">
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="mot_de_passe" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Confirmer le mot de passe</label>
        <input type="password" name="mot_de_passe2" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
</form>
<?php include 'footer.php'; ?>