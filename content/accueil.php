<?php
// S'assurer que la classe Utilisateur est bien disponible
require_once(__DIR__ . '/../admin/src/php/utils/all_includes.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


?>



<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Bienvenue chez Concessionnaire Bonem 🚗</h1>
        <?php if (isset($_SESSION['prenom']) && isset($_SESSION['role'])): ?>
            <p class="alert alert-success">
                Bonjour <strong><?= htmlspecialchars($_SESSION['prenom']) ?></strong> !
                Vous êtes connecté en tant que <strong><?= htmlspecialchars($_SESSION['role']) ?></strong>.
            </p>
        <?php endif; ?>


        <p class="lead">Découvrez nos voitures neuves et d’occasion. Consultez notre catalogue ou connectez-vous pour accéder à votre espace.</p>
        <hr class="my-4">

        <?php
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur'] instanceof Utilisateur):
            $prenom = htmlspecialchars($_SESSION['utilisateur']->getPrenom());
            $role = htmlspecialchars($_SESSION['utilisateur']->getRole());
            ?>

            <?php if ($role === 'admin'): ?>
            <a class="btn btn-primary btn-lg" href="admin/index_.php?page=admin_dashboard.php">Accéder au panneau admin</a>
        <?php else: ?>
            <a class="btn btn-secondary btn-lg" href="index_.php?page=voitures.php">Voir les voitures</a>
        <?php endif; ?>
        <?php endif; ?>

        <?php
        if (isset($_SESSION['prenom']) && isset($_SESSION['role'])):
            // L'utilisateur est connecté
            $role = $_SESSION['role'];
            ?>
            <a class="btn btn-primary btn-lg" href="index_.php?page=voitures.php">Voir les voitures</a>
        <?php else: ?>
            <a class="btn btn-primary btn-lg" href="index_.php?page=voitures.php">Voir les voitures</a>
            <a class="btn btn-outline-secondary btn-lg" href="index_.php?page=login.php">Se connecter</a>
        <?php endif; ?>

    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Nos Services</h3>
            <ul>
                <li>Vente de véhicules neufs</li>
                <li>Occasions garanties</li>
                <li>Révisions & entretiens</li>
                <li>Service après-vente</li>
            </ul>
        </div>
        <div class="col-md-6">
            <img src="admin/assets/images/garage.jpg" alt="Garage" class="img-fluid rounded shadow">
        </div>
    </div>
</div>
