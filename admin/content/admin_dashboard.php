<?php

require_once(__DIR__ . '/../src/php/utils/all_includes.php');
require_once(__DIR__ . '/../src/php/utils/check_connection.php');
?>

<div class="container">
    <h1>Bienvenue dans l'espace administrateur</h1>
    <p>Que souhaitez-vous gérer ?</p>

    <div class="list-group">
        <a href="index_.php?page=admin_voitures.php" class="list-group-item list-group-item-action">Voitures</a>
        <a href="index_.php?page=utilisateurs.php" class="list-group-item list-group-item-action">Utilisateurs</a>

        <a href="#" class="list-group-item list-group-item-action disabled">Commandes (bientôt)</a>
    </div>
</div>




