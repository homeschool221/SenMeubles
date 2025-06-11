<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login_admin.php");
    exit;
}
$conn = new mysqli("localhost", "root", "", "senmeubles");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
header("Location: liste.php");
exit;
?>

<body>
    <div class="container">
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <a href="liste.php" style="display:block;text-align:center;">Retour à la liste</a>
    </div>
</body>
</html>
