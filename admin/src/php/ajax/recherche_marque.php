<?php
require_once("../utils/all_includes.php");

$recherche = $_POST['recherche'] ?? '';
$dao = new MarqueDAO();
$marques = $dao->getByNom($recherche);

foreach ($marques as $marque) {
    echo '<div class="col">';
    echo '<div class="card text-center shadow-sm">';
    if (!empty($marque['logo'])) {
        echo '<img src="' . htmlspecialchars($marque['logo']) . '" class="card-img-top p-3" style="max-height: 150px; object-fit: contain;">';
    }
    echo '<div class="card-footer"><strong>' . htmlspecialchars($marque['nom']) . '</strong></div>';
    echo '</div></div>';
}
