<?php
session_start();
session_destroy();
header("Location: ../index_.php?page=accueil.php");



//<meta http-equiv="refresh" content="0;url=../index_.php?page=accueil.php">//
?>