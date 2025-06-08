<?php
require_once "admin/src/php/utils/all_includes.php";
$db = getConnection();

session_start();

$id_modele = $_GET['id_modele'] ?? null;
$option = $_GET['option'] ?? 'emporter';
$adresse = $_GET['adresse'] ?? null;
$email_client = $_SESSION['utilisateur']->email ?? ($_SESSION['email_temp'] ?? null);

// Sécurité
if (!$id_modele || !in_array($option, ['emporter', 'livraison'])) {
    die("Paramètres invalides.");
}

// Vérification modèle
$stmt = $db->prepare("SELECT * FROM modele WHERE id_modele = ?");
$stmt->execute([$id_modele]);
$modele = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$modele) {
    die("Modèle introuvable.");
}

// Enregistrement
$stmt = $db->prepare("INSERT INTO commande (id_modele, email_client, adresse_livraison, option_livraison)
                      VALUES (?, ?, ?, ?)");
$stmt->execute([$id_modele, $email_client, $adresse, $option]);

// Récupération ID
$id_commande = $db->lastInsertId();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu de commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h1 class="mb-4">Reçu de commande</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($modele['nom_modele']) ?></h5>
        <p class="card-text">
            <strong>Commande N° :</strong> <?= $id_commande ?><br>
            <strong>Date :</strong> <?= date('d/m/Y H:i') ?><br>
            <strong>Email client :</strong> <?= htmlspecialchars($email_client ?? 'Non fourni') ?><br>
            <strong>Option :</strong> <?= ucfirst($option) ?><br>
            <?php if ($option === 'livraison'): ?>
                <strong>Adresse :</strong> <?= nl2br(htmlspecialchars($adresse)) ?><br>
                <strong>Frais de livraison :</strong> 250.00 €
            <?php else: ?>
                <strong>À retirer sur place.</strong>
            <?php endif; ?>
        </p>
    </div>
</div>

<a href="index_.php" class="btn btn-primary mt-4">Retour à l'accueil</a>

</body>
</html>
