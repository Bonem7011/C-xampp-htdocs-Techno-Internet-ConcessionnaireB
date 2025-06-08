<?php
require ('src/php/utils/check_connection.php');
$admin = $_SESSION["utilisateur"];

print"<br>\nBonjour".$_SESSION['admin']."<br>";
?>


<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Admin - Tableau de bord</title></head>
<body>

<h1>Bienvenue dans l'espace admin, <?= htmlspecialchars($admin->prenom) ?> !</h1>

<ul>
    <li><a href="marques.php">Gérer les marques</a></li>
    <li><a href="modeles.php">Gérer les modèles</a></li>
    <li><a href="utilisateurs.php">Gérer les utilisateurs</a></li>
</ul>

<a href="../logout.php">Se déconnecter</a>

</body>
</html>