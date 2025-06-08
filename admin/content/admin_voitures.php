<?php
// ===== admin/content/admin_voitures.php =====
require_once(__DIR__ . '/../src/php/utils/all_includes.php');
require_once(__DIR__ . '/../src/php/utils/check_connection.php');

$db = getConnection();

// Récupérer les voitures avec jointures modèle et marque
$sql = "SELECT v.id_voiture, v.immatriculation, v.couleur, v.disponible,
               m.nom_modele, m.motorisation, m.image AS image_modele,
               ma.nom AS marque
        FROM voiture v
        JOIN modele m ON v.id_modele = m.id_modele
        JOIN marque ma ON m.id_marque = ma.id
        ORDER BY v.id_voiture DESC";

$voitures = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supprimer_voiture'])) {
        VoitureDAO::supprimerVoiture($_POST['id_voiture']);
        setFlash("Voiture supprimée avec succès.");
    }

    if (isset($_POST['changer_dispo'])) {
        $dispo = $_POST['disponible'] === '1' ? true : false;
        VoitureDAO::majDisponibilite($_POST['id_voiture'], $dispo);
        setFlash("Disponibilité mise à jour.");
    }
}

?>

<h1>Liste des voitures</h1>

<a href="index_.php?page=ajouter_voiture.php" class="btn btn-primary mb-3">Ajouter une voiture</a>

<table class="table table-bordered">
    <thead>

    <tr>
        <th>ID</th>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Motorisation</th>
        <th>Couleur</th>
        <th>Immatriculation</th>
        <th>Disponible</th>
        <th>Image</th>
        <th>Actions</th>

        <td>
            <form method="POST" onsubmit="return confirm('Supprimer cette voiture ?');">
                <input type="hidden" name="id_voiture" value="<?= $v['id_voiture'] ?>">
                <button type="submit" name="supprimer_voiture" class="btn btn-danger btn-sm">Supprimer</button>
            </form>
        </td>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($voitures as $v): ?>
        <tr>
            <td><?= $v['id_voiture'] ?></td>
            <td><?= htmlspecialchars($v['marque']) ?></td>
            <td><?= htmlspecialchars($v['nom_modele']) ?></td>
            <td><?= htmlspecialchars($v['motorisation']) ?></td>
            <td><?= htmlspecialchars($v['couleur']) ?></td>
            <td><?= htmlspecialchars($v['immatriculation']) ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id_voiture" value="<?= $v['id_voiture'] ?>">
                    <input type="hidden" name="disponible" value="<?= $v['disponible'] ? 0 : 1 ?>">
                    <button type="submit" name="changer_dispo" class="btn btn-sm <?= $v['disponible'] ? 'btn-warning' : 'btn-success' ?>">
                        <?= $v['disponible'] ? 'Rendre indisponible' : 'Rendre disponible' ?>
                    </button>
                </form>
            </td>

            <td>
                <?php if (!empty($v['image_modele'])): ?>
                    <img src="../assets/images/modeles/<?= $v['image_modele'] ?>" alt="modèle" style="max-height:60px;">
                <?php else: ?>
                    <em>Pas d'image</em>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
