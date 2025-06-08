<?php
require_once "admin/src/php/db/db_pg_connect.php";
session_start();
if (!isset($_SESSION["utilisateur"])) {
    header("Location: ../login.php");
    exit();
}

// Supprimer utilisateur
if (isset($_GET["supprimer"])) {
    $stmt = $db->prepare("DELETE FROM utilisateur WHERE id = ?");
    $stmt->execute([$_GET["supprimer"]]);
    header("Location: utilisateurs.php");
    exit();
}

// Modifier utilisateur
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modifier"])) {
    $stmt = $db->prepare("UPDATE utilisateur SET nom=?, prenom=?, email=?, numero_tel=? WHERE id=?");
    $stmt->execute([
        $_POST["nom"],
        $_POST["prenom"],
        $_POST["email"],
        $_POST["numero_tel"],
        $_POST["id"]
    ]);
    header("Location: utilisateurs.php");
    exit();
}

// Charger utilisateur à modifier
$modifie = null;
if (isset($_GET["modifier"])) {
    $stmt = $db->prepare("SELECT * FROM utilisateur WHERE id = ?");
    $stmt->execute([$_GET["modifier"]]);
    $modifie = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer tous les utilisateurs
$utilisateurs = $db->query("SELECT * FROM utilisateur ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Admin - Utilisateurs</title></head>
<body>

<h1>Gestion des utilisateurs</h1>

<?php if ($modifie): ?>
    <h2>Modifier un utilisateur</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $modifie["id"] ?>">
        Nom : <input type="text" name="nom" value="<?= htmlspecialchars($modifie["nom"]) ?>" required><br>
        Prénom : <input type="text" name="prenom" value="<?= htmlspecialchars($modifie["prenom"]) ?>" required><br>
        Email : <input type="email" name="email" value="<?= htmlspecialchars($modifie["email"]) ?>" required><br>
        Numéro : <input type="text" name="numero_tel" value="<?= htmlspecialchars($modifie["numero_tel"]) ?>"><br><br>
        <button type="submit" name="modifier">Mettre à jour</button>
    </form>
<?php endif; ?>

<h2>Liste des utilisateurs</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th><th>Actions</th>
    </tr>
    <?php foreach ($utilisateurs as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u["nom"]) ?></td>
            <td><?= htmlspecialchars($u["prenom"]) ?></td>
            <td><?= htmlspecialchars($u["email"]) ?></td>
            <td><?= htmlspecialchars($u["numero_tel"]) ?></td>
            <td>
                <a href="?modifier=<?= $u["id"] ?>">Modifier</a> |
                <a href="?supprimer=<?= $u["id"] ?>" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="../index_.php">← Retour au tableau de bord</a>

</body>
</html>
