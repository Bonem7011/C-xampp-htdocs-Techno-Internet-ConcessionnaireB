<?php

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../classes/' . $class . '.class.php',
        __DIR__ . '/../../../admin/src/php/classes/' . $class . '.class.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once($path);
            break;
        }
    }
});



require_once(__DIR__ . '/../db/db_pg_connect.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function setFlash($message, $type = 'success') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type // success, danger, warning, info
    ];
}

function displayFlash() {
    if (isset($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];
        echo "<div class='alert alert-$type mt-3'>$message</div>";
        unset($_SESSION['flash']);
    }
}

$db = getConnection();




/*

//Si on se trouve dans la partie admin
spl_autoload_register(function ($class) {
    include_once("admin/src/php/classes/" . $class . ".class.php");
    include_once("admin/src/php/classes/" . $class . ".class.php");
});
require_once("admin/src/php/db/db_pg_connect.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
*/