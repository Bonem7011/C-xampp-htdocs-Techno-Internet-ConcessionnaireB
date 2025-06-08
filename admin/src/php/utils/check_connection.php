<?php
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Techno%20internet/ConcessionnaireB/index_.php?page=login.php");
    exit();
}
