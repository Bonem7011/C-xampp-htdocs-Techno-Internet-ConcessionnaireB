<?php
require_once("../utils/all_includes.php");

$id_marque = $_POST['id_marque'] ?? 0;
if (!is_numeric($id_marque)) exit;

$db = getConnection();
$stmt = $db->prepare("SELECT nom_modele FROM modele WHERE id_marque = ? ORDER BY nom_modele");
$stmt->execute([$id_marque]);
$modeles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($modeles)) {
    echo "<p>Aucun modèle trouvé.</p>";
} else {
    echo "<ul class='list-group'>";
    foreach ($modeles as $modele) {
        echo "<li class='list-group-item'>" . htmlspecialchars($modele['nom_modele']) . "</li>";
    }
    echo "</ul>";
}
