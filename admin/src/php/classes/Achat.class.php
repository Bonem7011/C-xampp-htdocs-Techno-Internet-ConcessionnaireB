<?php
class Achat {
    public $id_achat;
    public $id_utilisateur;
    public $id_voiture;
    public $type_livraison;
    public $adresse_livraison;
    public $prix_total;
    public $date_achat;

    public function __construct($id_achat = null, $id_utilisateur = null, $id_voiture = null, $type_livraison = "", $adresse_livraison = "", $prix_total = 0.0, $date_achat = null) {
        $this->id_achat = $id_achat;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_voiture = $id_voiture;
        $this->type_livraison = $type_livraison;
        $this->adresse_livraison = $adresse_livraison;
        $this->prix_total = $prix_total;
        $this->date_achat = $date_achat;
    }
}
