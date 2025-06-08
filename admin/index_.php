<?php

// ===== admin/index_.php =====
if (session_status() === PHP_SESSION_NONE) session_start();

require_once('./src/php/utils/all_includes.php');
require_once('./src/php/utils/check_connection.php'); // vérifie si admin

// Récupérer la page demandée ou défaut
$page = $_GET['page'] ?? $_SESSION['admin_page'] ?? 'admin_dashboard.php';

// Lister les fichiers valides dans admin/content
$allowed_pages = array_filter(scandir('./content'), function($f) {
    return pathinfo($f, PATHINFO_EXTENSION) === 'php';
});

if (!in_array($page, $allowed_pages)) {
    $page = 'page404.php';
}

$_SESSION['admin_page'] = $page;


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Administration - Concessionnaire' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="./assets/js/fonctionsJqueryMission.js" defer></script>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div id="page" class="container">
    <header class="img_header mb-3"></header>
    <nav>
        <?php include('./src/php/utils/admin_menu.php'); ?>
    </nav>
    <section id="contenu" class="mt-4">
        <div class="container">
            <?php include('./content/' . $page); ?>
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

