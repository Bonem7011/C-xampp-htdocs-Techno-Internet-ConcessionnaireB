<?php
require_once("admin/src/php/utils/all_includes.php");

$utilisateur = new Utilisateur(
    1,
    "Durand",
    "Alice",
    "alice@mail.com",
    "motdepasse123",
    "0478123456",
    "client"
);

$_SESSION['utilisateur'] = $utilisateur;

echo "Utilisateur stocké en session.<br>";
echo "<a href='test_affiche_utilisateur.php'>Aller à l'affichage</a>";
