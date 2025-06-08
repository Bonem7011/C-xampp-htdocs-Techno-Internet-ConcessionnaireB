<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "admin/src/php/utils/all_includes.php";

$erreur = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $telephone = $_POST["telephone"];

    // Vérification si l'utilisateur existe déjà
    $dao = new UtilisateurDAO();
    if ($dao->getUtilisateurByEmail($email)) {
        $erreur = "Un compte avec cet email existe déjà.";
    } else {
        $utilisateur = new Utilisateur(null, $nom, $prenom, $email, $mot_de_passe, $telephone, "client");
        $dao->insert($utilisateur);
        $message = "Inscription réussie. Vous pouvez maintenant vous connecter.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center" style="min-height: 95vh;">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center mb-4">📝 Inscription</h2>

                <?php if ($erreur): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
                <?php elseif ($message): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Créer mon compte</button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <a href="index_.php?page=login.php">Déjà inscrit ? Se connecter</a>
                </div>
            </div>
        </div>


    </div>
</div>

</body>
</html>
