<?php
require_once(__DIR__ . '/../admin/src/php/utils/all_includes.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $dao = new UtilisateurDAO();
    $utilisateur = $dao->getUtilisateurByEmail($email);

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur->getMotDePasse())) {
        $_SESSION["prenom"] = $utilisateur->getPrenom();
        $_SESSION["role"] = $utilisateur->getRole();
        $_SESSION["user"] = $utilisateur; // 🔧 C'est ça qu'il manquait

        setFlash("Connexion réussie ! Bienvenue " . $_SESSION["prenom"] . " 👋", "success");

        if ($_SESSION["role"] === "admin") {
            header("Location: ./admin/index_.php?page=admin_dashboard.php");
        } else {
            header("Location: index_.php?page=accueil.php");
        }
        exit();

}else {
        setFlash("Email ou mot de passe incorrect.", "danger");
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">🔐 Connexion</h2>

                        <?php if ($erreur): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control" id="mot_de_passe" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="index_.php?page=inscription.php">Pas encore inscrit ? S'inscrire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


<?php if (!empty($erreur)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>
