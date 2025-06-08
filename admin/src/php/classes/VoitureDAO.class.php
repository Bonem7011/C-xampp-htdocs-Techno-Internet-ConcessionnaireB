<?php
class VoitureDAO {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    public function getAllVoitures() {
        $stmt = $this->db->prepare("SELECT * FROM get_all_voitures()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVoitureById($id) {
        $stmt = $this->db->prepare("SELECT * FROM voiture WHERE id_voiture = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterVoiture(Voiture $v) {
        $stmt = $this->db->prepare("SELECT ajouter_voiture(?, ?, ?, ?)");
        $stmt->execute([
            $v->getIdModele(),
            $v->getCouleur(),
            $v->getImmatriculation(),
            $v->isDisponible()
        ]);
    }



    public function getVoituresDisponibles() {
        $stmt = $this->db->prepare("
            SELECT v.id_voiture, v.couleur, v.immatriculation, m.nom_modele, ma.nom AS marque
            FROM voiture v
            JOIN modele m ON v.id_modele = m.id_modele
            JOIN marque ma ON m.id_marque = ma.id
            WHERE v.disponible = TRUE
            ORDER BY ma.nom, m.nom_modele
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filter($marque = "", $modele = "", $couleur = "") {
        $sql = "
            SELECT v.id_voiture, v.couleur, v.immatriculation, m.nom_modele,m.image, ma.nom AS marque
            FROM voiture v
            JOIN modele m ON v.id_modele = m.id_modele
            JOIN marque ma ON m.id_marque = ma.id
            WHERE v.disponible = TRUE";
        $params = [];

        if (!empty($marque)) {
            $sql .= " AND LOWER(ma.nom) LIKE LOWER(?)";
            $params[] = "%$marque%";
        }
        if (!empty($modele)) {
            $sql .= " AND LOWER(m.nom_modele) LIKE LOWER(?)";
            $params[] = "%$modele%";
        }
        if (!empty($couleur)) {
            $sql .= " AND LOWER(v.couleur) LIKE LOWER(?)";
            $params[] = "%$couleur%";
        }

        $stmt = $this->db->prepare($sql . " ORDER BY ma.nom, m.nom_modele");
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function supprimerVoiture($id_voiture) {
        $db = getConnection();
        $sql = "DELETE FROM voiture WHERE id_voiture = :id_voiture";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id_voiture' => $id_voiture]);
    }

    public static function majDisponibilite($id_voiture, $disponible) {
        $db = getConnection();
        $sql = "UPDATE voiture SET disponible = :disponible WHERE id_voiture = :id_voiture";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id_voiture' => $id_voiture,
            ':disponible' => $disponible
        ]);
    }

}
