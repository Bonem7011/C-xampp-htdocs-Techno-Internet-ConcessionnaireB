<?php
require_once("../src/php/utils/all_includes.php");
$pdo = getConnection();
session_start();

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ../../login.php");
    exit();
}

// 🔁 Traitements actions (changer statut / suppression)
if (isset($_GET['changer_statut'])) {
    $id = (int) $_GET['changer_statut'];
    $pdo->prepare("UPDATE commande SET statut = 'expédiée' WHERE id_commande = ?")->execute([$id]);
    header("Location: index_.php?page=admin_commandes.php");
    exit();
}

if (isset($_GET['supprimer'])) {
    $id = (int) $_GET['supprimer'];
    $pdo->prepare("DELETE FROM commande WHERE id_commande = ?")->execute([$id]);
    header("Location: index_.php?page=admin_commandes.php");
    exit();
}

// 📥 Récupération des filtres
$statut = $_GET['statut'] ?? '';
$debut = $_GET['debut'] ?? '';
$fin = $_GET['fin'] ?? '';
$email = $_GET['email'] ?? '';

// 🔎 Construction dynamique de la requête
$sql = "
    SELECT c.*, m.nom_modele, ma.nom AS marque
    FROM commande c
    JOIN modele m ON c.id_modele = m.id_modele
    JOIN marque ma ON m.id_marque = ma.id
    WHERE 1=1
";
$params = [];

if ($statut !== '') {
    $sql .= " AND c.statut = :statut";
    $params[':statut'] = $statut;
}
if ($debut !== '') {
    $sql .= " AND c.date_commande >= :debut";
    $params[':debut'] = $debut . " 00:00:00";
}
if ($fin !== '') {
    $sql .= " AND c.date_commande <= :fin";
    $params[':fin'] = $fin . " 23:59:59";
}
if ($email !== '') {
    $sql .= " AND c.email_client ILIKE :email";
    $params[':email'] = '%' . $email . '%';
}

$sql .= " ORDER BY c.date_commande DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h2 class="mb-4">📦 Liste des commandes</h2>

<!-- 🔎 Filtres -->
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <label class="form-label">Date début</label>
        <input type="date" name="debut" class="form-control" value="<?= htmlspecialchars($debut) ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Date fin</label>
        <input type="date" name="fin" class="form-control" value="<?= htmlspecialchars($fin) ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-select">
            <option value="">-- Tous --</option>
            <option value="en cours" <?= $statut === "en cours" ? "selected" : "" ?>>En cours</option>
            <option value="expédiée" <?= $statut === "expédiée" ? "selected" : "" ?>>Expédiée</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Email client</label>
        <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" placeholder="ex: client@email.com">
    </div>
    <div class="col-12 text-end mt-2">
        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="index_.php?page=admin_commandes.php" class="btn btn-secondary">Réinitialiser</a>
    </div>
</form>

<?php if (empty($commandes)): ?>
    <div class="alert alert-warning">Aucune commande ne correspond aux filtres.</div>
<?php else: ?>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Client</th>
            <th>Modèle</th>
            <th>Marque</th>
            <th>Option</th>
            <th>Adresse</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($commandes as $cmd): ?>
            <tr>
                <td><?= $cmd['id_commande'] ?></td>
                <td><?= date("d/m/Y H:i", strtotime($cmd['date_commande'])) ?></td>
                <td><?= htmlspecialchars($cmd['email_client']) ?></td>
                <td><?= htmlspecialchars($cmd['nom_modele']) ?></td>
                <td><?= htmlspecialchars($cmd['marque']) ?></td>
                <td><?= ucfirst($cmd['option_livraison']) ?></td>
                <td><?= nl2br(htmlspecialchars($cmd['adresse_livraison'])) ?></td>
                <td>
                    <?php if ($cmd['statut'] === 'expédiée'): ?>
                        <span class="badge bg-secondary">Expédiée</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">En cours</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($cmd['statut'] !== 'expédiée'): ?>
                        <a href="?changer_statut=<?= $cmd['id_commande'] ?>" class="btn btn-sm btn-success mb-1">Marquer expédiée</a>
                    <?php endif; ?>
                    <a href="?supprimer=<?= $cmd['id_commande'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer la commande #<?= $cmd['id_commande'] ?> ?')">🗑</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="../index_.php" class="btn btn-outline-secondary mt-4">← Retour au tableau de bord</a>

</body>
</html>
