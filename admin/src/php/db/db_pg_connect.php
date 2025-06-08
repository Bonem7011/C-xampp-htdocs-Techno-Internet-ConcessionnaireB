<?php

function getConnection() {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "pgsql:host=localhost;dbname=ConcessionnaireBonem;port=5432";
        $user = "anonyme";
        $password = "anonyme";

        try {
            $pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    return $pdo;
}
