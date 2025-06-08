<?php
require_once "admin/src/php/db/db_pg_connect.php";
session_start();
if (!isset($_SESSION["utilisateur"])) {
    header("Location: ../login.php");
    exit();
}

// Récupérer les marques pour le menu déroulant
$marques = $db->query("SELECT * FROM marque ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Ajouter un modèle
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajouter"])) {
    $stmt = $db->prepare("INSERT INTO modele (nom, description, caracteristiques, prix, id_marque)
                          VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST["nom"],
        $_POST["description"],
        $_POST["caracteristiques"],
        $_POST["prix"],
        $_POST["id_marque"]
    ]);
    header("Location: modele.php");
    exit();
}

// Modifier un modèle
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modifier"])) {
    $stmt = $db->prepare("UPDATE modele SET nom=?, description=?, caracteristiques=?, prix=?, id_marque=? WHERE id=?");
    $stmt->execute([
        $_POST["nom"],
        $_POST["description"],
        $_POST["caracteristiques"],
        $_POST["prix"],
        $_POST["id_marque"],
        $_POST["id"]
    ]);
    header("Location: modele.php");
    exit();
}

// Supprimer un modèle
if (isset($_GET["supprimer"])) {
    $stmt = $db->prepare("DELETE FROM modele WHERE id = ?");
    $stmt->execute([$_GET["supprimer"]]);
    header("Location: modele.php");
    exit();
}

// Récupérer tous les modèles
$modeles = $db->query("
    SELECT m.id, m.nom, m.description, m.caracteristiques, m.prix, marque.nom AS nom_marque
    FROM modele m
    JOIN marque ON m.id_marque = marque.id
    ORDER BY m.nom
")->fetchAll(PDO::FETCH_ASSOC);

// Si édition, récupérer le modèle
$modifie = null;
if (isset($_GET["modifier"])) {
    $stmt = $db->prepare("SELECT * FROM modele WHERE id = ?");
    $stmt->execute([$_GET["modifier"]]);
    $modifie = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Admin - Modèles</title></head>
<body>

<h1>Gestion des modèles de voiture</h1>

<h2><?= $modifie ? "Modifier" : "Ajouter" ?> un modèle</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= $modifie["id"] ?? "" ?>">
    Nom : <input type="text" name="nom" value="<?= $modifie["nom"] ?? "" ?>" required><br>
    Description : <textarea name="description"><?= $modifie["description"] ?? "" ?></textarea><br>
    Caractéristiques : <textarea name="caracteristiques"><?= $modifie["caracteristiques"] ?? "" ?></textarea><br>
    Prix (€) : <input type="number" step="0.01" name="prix" value="<?= $modifie["prix"] ?? "" ?>" required><br>
    Marque :
    <select name="id_marque" required>
        <?php foreach ($marques as $marque): ?>
            <option value="<?= $marque["id"] ?>" <?= ($modifie && $modifie["id_marque"] == $marque["id"]) ? "selected" : "" ?>>
                <?= htmlspecialchars($marque["nom"]) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    <button type="submit" name="<?= $modifie ? "modifier" : "ajouter" ?>">
        <?= $modifie ? "Mettre à jour" : "Ajouter" ?>
    </button>
</form>

<h2>Liste des modèles</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Nom</th><th>Marque</th><th>Prix (€)</th><th>Actions</th>
    </tr>
    <?php foreach ($modeles as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m["nom"]) ?></td>
            <td><?= htmlspecialchars($m["nom_marque"]) ?></td>
            <td><?= number_format($m["prix"], 2) ?></td>
            <td>
                <a href="?modifier=<?= $m["id"] ?>">Modifier</a> |
                <a href="?supprimer=<?= $m["id"] ?>" onclick="return confirm('Supprimer ce modèle ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="../index_.php">← Retour au tableau de bord</a>

</body>
</html>