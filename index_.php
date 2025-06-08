<?php
// Charger les classes avant la session pour éviter les erreurs avec les objets en session
require_once('./admin/src/php/utils/all_includes.php');

// Démarrer la session après que les classes soient disponibles
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Définir le titre si non déjà défini
$title = $title ?? "Concessionnaire Bonem";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="./admin/assets/js/fonctionsJqueryUI.js"></script>
    <link rel="stylesheet" href="./admin/assets/css/style.css">
</head>

<body>
<div id="page" class="container">
    <header class="img_header"></header>

    <nav>
        <?php include('admin/src/php/utils/public_menu.php'); ?>
    </nav>
    <?php displayFlash(); ?>


    <section id="contenu" class="mt-4">
        <div class="container">
            <?php
            // Déterminer quelle page charger
            $page = $_GET['page'] ?? $_SESSION['page'] ?? 'accueil.php';

            // Enregistrer la page dans la session
            $_SESSION['page'] = $page;

            // Sécuriser l'inclusion
            $allowed_pages = scandir('./content');
            if (in_array($page, $allowed_pages)) {
                include('./content/' . $page);
            } else {
                include('./content/page404.php');
            }
            ?>
        </div>
    </section>
</div>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">Concessionnaire Bonem 2025</span>
    </div>
</footer>
</body>
</html>
