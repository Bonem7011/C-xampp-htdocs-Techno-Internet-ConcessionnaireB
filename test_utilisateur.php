<?php
session_start();

// Inclusion de la classe Utilisateur (chemin correct à adapter)
require_once("admin/src/php/classes/Utilisateur.class.php");

// Création d'un utilisateur fictif
$utilisateur = new Utilisateur(1, "Durand", "Alice", "alice@mail.com", "motdepasse", "0488123456", "client");

// Mise en session
$_SESSION['utilisateur'] = $utilisateur;

// Affichage pour test
echo "<h2>Test de la classe Utilisateur</h2>";
echo "<p>Prénom : " . $_SESSION['utilisateur']->getPrenom() . "</p>";
echo "<p>Nom : " . $_SESSION['utilisateur']->getNom() . "</p>";
echo "<p>Email : " . $_SESSION['utilisateur']->getEmail() . "</p>";
echo "<p>Rôle : " . $_SESSION['utilisateur']->getRole() . "</p>";
?>
