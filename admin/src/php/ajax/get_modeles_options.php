<?php
require_once("../utils/all_includes.php");

$id_marque = $_POST['id_marque'] ?? 0;
$db = getConnection();

$stmt = $db->prepare("SELECT id_modele, nom_modele FROM modele WHERE id_marque = ? ORDER BY nom_modele");
$stmt->execute([$id_marque]);
$modeles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<option value=''>-- Sélectionner un modèle --</option>";
foreach ($modeles as $modele) {
    echo "<option value='" . $modele['id_modele'] . "'>" . htmlspecialchars($modele['nom_modele']) . "</option>";
}
