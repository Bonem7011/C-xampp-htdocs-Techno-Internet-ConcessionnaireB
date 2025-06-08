<?php
require_once "admin/src/php/utils/all_includes.php";
session_start();
$db = getConnection();

if (!isset($_GET["id_modele"])) {
    die("Aucun modèle sélectionné.");
}

$id_modele = (int) $_GET["id_modele"];

$stmt = $db->prepare("SELECT * FROM modele WHERE id_modele = ?");
$stmt->execute([$id_modele]);
$modele = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$modele) {
    die("Modèle introuvable.");
}

$livraison_prix = 250.00;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $option = $_POST["option"];
    $adresse = $_POST["adresse"] ?? "";
    $email_temp = $_POST["email_temp"] ?? "";

    if ($option === "livraison" && empty($adresse)) {
        $erreur = "Veuillez entrer une adresse pour la livraison.";
    } elseif (!isset($_SESSION['utilisateur']) && empty($email_temp)) {
        $erreur = "Veuillez fournir un email pour finaliser l’achat.";
    } else {
        if (!isset($_SESSION['utilisateur'])) {
            $_SESSION['email_temp'] = $email_temp;
        }

        // Redirection vers la page de reçu
        $query = http_build_query([
            'id_modele' => $id_modele,
            'option' => $option,
            'adresse' => $adresse
        ]);
        header("Location: recu.php?$query");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Achat - <?= htmlspecialchars($modele["nom_modele"]) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleAdresse() {
            const livraison = document.getElementById('livraison');
            const adresseField = document.getElementById('adresse-livraison');
            adresseField.style.display = livraison.checked ? 'block' : 'none';
        }
    </script>
</head>
<body class="container py-5">

<h1 class="mb-4">Achat du modèle <?= htmlspecialchars($modele["nom_modele"]) ?></h1>

<?php if (!empty($erreur)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<form method="POST" class="border p-4 shadow-sm bg-light rounded">
    <?php if (!isset($_SESSION['utilisateur'])): ?>
        <div class="mb-3">
            <label>Email :</label>
            <input type="email" name="email_temp" class="form-control" required>
        </div>
    <?php endif; ?>

    <div class="form-check mb-2">
        <input type="radio" name="option" value="emporter" onclick="toggleAdresse()" checked class="form-check-input" id="emporter">
        <label for="emporter" class="form-check-label">Retrait sur place (gratuit)</label>
    </div>

    <div class="form-check mb-3">
        <input type="radio" name="option" value="livraison" id="livraison" onclick="toggleAdresse()" class="form-check-input">
        <label for="livraison" class="form-check-label">Livraison (+<?= number_format($livraison_prix, 2) ?> €)</label>
    </div>

    <div id="adresse-livraison" style="display: none;" class="mb-3">
        <label for="adresse">Adresse de livraison :</label>
        <textarea name="adresse" id="adresse" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Finaliser l'achat</button>
</form>

<a href="modele.php?id=<?= $id_modele ?>" class="btn btn-link mt-3">← Retour au modèle</a>

</body>
</html>
