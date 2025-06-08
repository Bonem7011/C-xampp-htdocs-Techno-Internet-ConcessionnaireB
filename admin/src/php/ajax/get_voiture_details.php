<?php
require_once("../utils/all_includes.php");

$id = $_POST['id_voiture'] ?? null;
if ($id) {
    $dao = new VoitureDAO();
    $v = $dao->getVoitureById($id);
    if ($v) {
        echo "<h5>" . htmlspecialchars($v['immatriculation']) . "</h5>";
        echo "<p>Couleur : " . htmlspecialchars($v['couleur']) . "</p>";
        echo "<p>Disponible : " . ($v['disponible'] ? 'Oui' : 'Non') . "</p>";
    } else {
        echo "Voiture introuvable.";
    }
}
