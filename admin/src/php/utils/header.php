<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si une page est passée en GET, on la stocke en session
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}

// Page par défaut si aucune définie
if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 'accueil.php';
}

// Titre par défaut
$title = "Site PUBLIC - Concessionnaire";

switch ($_SESSION['page']) {
    case 'accueil.php':
        $title = "Accueil - Concessionnaire";
        break;
    case 'login.php':
        $title = "Connexion - Concessionnaire";
        break;
    case 'inscription.php':
        $title = "Inscription - Concessionnaire";
        break;
    case 'marque.php':
        $title = "Nos Marques - Concessionnaire";
        break;
    case 'modele.php':
        $title = "Modèle - Concessionnaire";
        break;
    case 'achat.php':
        $title = "Achat - Concessionnaire";
        break;
    default:
        $title = "Site PUBLIC - Concessionnaire";
}

// Vérifie si la page existe
if (!file_exists('content/' . $_SESSION['page'])) {
    $title = "Page introuvable | Concessionnaire";
    $_SESSION['page'] = 'page404.php';
}
?>
