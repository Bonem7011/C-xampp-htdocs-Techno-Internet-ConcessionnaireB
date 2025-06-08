<?php
class Modele {
    public $id_modele;
    public $id_marque;
    public $nom;
    public $description;
    public $caracteristiques;
    public $prix;

    public function __construct($id_modele = null, $id_marque = null, $nom = "", $description = "", $caracteristiques = "", $prix = 0.0) {
        $this->id_modele = $id_modele;
        $this->id_marque = $id_marque;
        $this->nom = $nom;
        $this->description = $description;
        $this->caracteristiques = $caracteristiques;
        $this->prix = $prix;
    }
}
