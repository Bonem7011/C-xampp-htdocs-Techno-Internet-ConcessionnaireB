<?php
require_once("admin/src/php/utils/all_includes.php");

$pdo = getConnection();
$marques = $pdo->query("SELECT * FROM marque ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
    <h2 class="text-center mb-4">Nos marques partenaires</h2>
    <div class="row row-cols-2 row-cols-md-4 g-4">
        <?php foreach ($marques as $marque): ?>
            <div class="col text-center">
                <a href="index_.php?page=marque.php&id=<?= $marque['id'] ?>">

                    <img src="admin/assets/images/marques/<?= htmlspecialchars($marque['logo']) ?>"
                    alt="<?= htmlspecialchars($marque['nom']) ?>"
                         class="img-fluid" style="max-height: 100px;">
                    <div class="mt-2 fw-bold"><?= htmlspecialchars($marque['nom']) ?></div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

