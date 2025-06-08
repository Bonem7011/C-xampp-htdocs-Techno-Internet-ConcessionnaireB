<?php
require_once("admin/src/php/utils/all_includes.php");

$dao = new VoitureDAO();

$marque = $_GET['marque'] ?? "";
$modele = $_GET['modele'] ?? "";
$couleur = $_GET['couleur'] ?? "";

$voitures = $dao->filter($marque, $modele, $couleur);
?>

<div class="container mt-4">
    <h2>Voitures disponibles</h2>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="marque" value="<?= htmlspecialchars($marque) ?>" class="form-control" placeholder="Filtrer par marque">
        </div>
        <div class="col-md-4">
            <input type="text" name="modele" value="<?= htmlspecialchars($modele) ?>" class="form-control" placeholder="Filtrer par modèle">
        </div>
        <div class="col-md-4">
            <input type="text" name="couleur" value="<?= htmlspecialchars($couleur) ?>" class="form-control" placeholder="Filtrer par couleur">
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="index_.php?page=voitures.php" class="btn btn-secondary">Réinitialiser</a>
        </div>
    </form>

    <?php if (empty($voitures)): ?>
        <div class="alert alert-warning">Aucune voiture ne correspond à votre recherche.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($voitures as $v): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($v['marque']) ?> - <?= htmlspecialchars($v['nom_modele']) ?></h5>
                            <?php if (!empty($v['image'])): ?>
                                <img src="admin/assets/images/modeles/<?= htmlspecialchars($v['image']) ?>" class="card-img-top mb-2" style="max-height: 150px;" alt="<?= htmlspecialchars($v['nom_modele']) ?>">
                            <?php endif; ?>

                            <p class="card-text">
                                Couleur : <?= htmlspecialchars($v['couleur']) ?><br>
                                Immatriculation : <?= htmlspecialchars($v['immatriculation']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
