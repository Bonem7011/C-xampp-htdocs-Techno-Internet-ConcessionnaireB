<?php
class ModeleDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByMarque($id_marque) {
        $stmt = $this->db->prepare("SELECT * FROM modele WHERE id_marque = ?");
        $stmt->execute([$id_marque]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Modele");
    }
}
