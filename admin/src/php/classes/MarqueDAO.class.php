<?php
class MarqueDAO {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM marque ORDER BY nom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(Marque $marque) {
        $stmt = $this->db->prepare("INSERT INTO marque (nom, logo) VALUES (?, ?)");
        $stmt->execute([$marque->getNom(), $marque->getLogo()]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM marque WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getByNom($terme) {
        $stmt = $this->db->prepare("SELECT * FROM marque WHERE LOWER(nom) LIKE LOWER(?) ORDER BY nom");
        $stmt->execute(['%' . $terme . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
