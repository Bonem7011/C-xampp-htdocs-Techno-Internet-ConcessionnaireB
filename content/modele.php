<?php
require_once "admin/src/php/db/db_pg_connect.php";

if (!isset($_GET["id"])) {
    die("Aucun modèle sélectionné.");
}

$id_modele = (int) $_GET["id"];

$stmt = $db->prepare("SELECT * FROM modele WHERE id = ?");
$stmt->execute([$id_modele]);
$modele = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$modele) {
    die("Modèle introuvable.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($modele["nom"]) ?></title>
</head>
<body>

<h1><?= htmlspecialchars($modele["nom"]) ?></h1>

<p><strong>Description :</strong> <?= nl2br(htmlspecialchars($modele["description"])) ?></p>
<p><strong>Caractéristiques :</strong> <?= nl2br(htmlspecialchars($modele["caracteristiques"])) ?></p>
<p><strong>Prix :</strong> <?= number_format($modele["prix"], 2) ?> €</p>

<form action="achat.php" method="GET">
    <input type="hidden" name="id_modele" value="<?= $modele['id'] ?>">
    <button type="submit">Acheter ce véhicule</button>
</form>

<a href="marque.php?id=<?= $modele['id_marque'] ?>">← Retour à la marque</a>

</body>
<footer>
    <?php require_once 'admin/src/php/utils/footer.php'; ?>
</footer>
</html>

