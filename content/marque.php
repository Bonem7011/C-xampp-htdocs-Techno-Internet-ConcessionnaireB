<?php
require_once("admin/src/php/utils/all_includes.php");

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    echo "<div class='alert alert-danger'>Marque inconnue.</div>";
    exit();
}

$pdo = getConnection();

// Récupérer la marque
$stmt = $pdo->prepare("SELECT * FROM marque WHERE id = ?");
$stmt->execute([$id]);
$marque = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$marque) {
    echo "<div class='alert alert-warning'>Marque non trouvée.</div>";
    exit();
}

// Récupérer les modèles associés
$stmt = $pdo->prepare("SELECT * FROM modele WHERE id_marque = ? ORDER BY nom_modele");
$stmt->execute([$id]);
$modeles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
    <a href="index_.php?page=nos_marques.php" class="btn btn-outline-secondary mb-3">← Retour aux marques</a>
    <h2 class="mb-4">Modèles de la marque <?= htmlspecialchars($marque['nom']) ?></h2>

    <?php if (empty($modeles)): ?>
        <div class="alert alert-info">Aucun modèle enregistré pour cette marque.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($modeles as $m): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($m['nom_modele']) ?></h5>
                            <img src="admin/assets/images/modeles/<?= htmlspecialchars($m['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($m['nom_modele']) ?>">


                            <p class="card-text">Motorisation : <?= htmlspecialchars($m['motorisation']) ?></p>
                            <a href="index_.php?page=achat.php&id_modele=<?= $m['id_modele'] ?>" class="btn btn-primary btn-sm">Acheter</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

