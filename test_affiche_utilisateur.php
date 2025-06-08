<?php
require_once("admin/src/php/utils/all_includes.php");

if (!isset($_SESSION['utilisateur'])) {
    echo "Aucun utilisateur trouvé en session.";
    exit;
}

$utilisateur = $_SESSION['utilisateur'];

echo "<h1>Données de l'utilisateur :</h1>";
echo "Nom : " . htmlspecialchars($utilisateur->getNom()) . "<br>";
echo "Prénom : " . htmlspecialchars($utilisateur->getPrenom()) . "<br>";
echo "Email : " . htmlspecialchars($utilisateur->getEmail()) . "<br>";
echo "Téléphone : " . htmlspecialchars($utilisateur->getTelephone()) . "<br>";
echo "Rôle : " . htmlspecialchars($utilisateur->getRole()) . "<br>";
