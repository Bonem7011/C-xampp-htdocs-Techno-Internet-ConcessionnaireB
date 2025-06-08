<?php
require_once("../src/php/utils/all_includes.php");
require_once("../src/php/utils/check_connection.php");

$dao = new MarqueDAO();
$success = "";
$error = "";

// Ajout
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajouter"])) {
    $nom = $_POST["nom"] ?? '';
    $logo = $_POST["logo"] ?? '';

    if (!empty($nom)) {
        $marque = new Marque(null, $nom, $logo);
        $dao->insert($marque);
        $success = "Marque ajoutée avec succès.";
    } else {
        $error = "Le nom est obligatoire.";
    }
}

// Suppression
if (isset($_GET["supprimer"])) {
    $dao->delete($_GET["supprimer"]);
    $success = "Marque supprimée.";
}

// Chargement des marques
$marques = $dao->getAll();
?>

<div class="container">
    <h2>Gestion des marques</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-4">
        <input type="text" name="nom" class="form-control mb-2" placeholder="Nom de la marque" required>
        <input type="text" name="logo" class="form-control mb-2" placeholder="URL du logo">
        <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
    </form>

    <ul class="list-group">
        <?php foreach ($marques as $marque): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($marque["nom"]) ?>
                <a href="?supprimer=<?= $marque["id"] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Supprimer cette marque ?')">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="index_.php?page=admin_dashboard.php" class="btn btn-link mt-3">← Retour au tableau de bord</a>
</div>
