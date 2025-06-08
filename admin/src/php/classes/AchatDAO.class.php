<?php
class AchatDAO {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insert(Achat $achat) {
        $stmt = $this->db->prepare("INSERT INTO achat (id_utilisateur, id_voiture, type_livraison, adresse_livraison, prix_total) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $achat->id_utilisateur,
            $achat->id_voiture,
            $achat->type_livraison,
            $achat->adresse_livraison,
            $achat->prix_total
        ]);
    }
}
