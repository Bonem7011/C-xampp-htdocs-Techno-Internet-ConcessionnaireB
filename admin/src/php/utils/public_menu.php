<?php
require_once(__DIR__ . '/all_includes.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$utilisateur = $_SESSION['utilisateur'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="index_.php?page=accueil.php">Concessionnaire Bonem</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index_.php?page=accueil.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="index_.php?page=voitures.php">Nos voitures</a></li>
                <li class="nav-item"><a class="nav-link" href="index_.php?page=contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="index_.php?page=nos_marques.php">Nos marques</a></li>
                <li class="nav-item"><a class="nav-link" href="index_.php?page=voitures.php">Voitures en stock</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['prenom']) && isset($_SESSION['role'])): ?>

                    <li class="nav-item">
                        <a class="nav-link disabled">Bonjour, <?= htmlspecialchars($_SESSION['prenom']) ?></a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index_.php?page=logout.php">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index_.php?page=login.php">Se connecter</a></li>
                    <li class="nav-item"><a class="nav-link" href="index_.php?page=inscription.php">S'inscrire</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
