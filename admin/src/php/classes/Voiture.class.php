<?php
class Voiture
{
    private $id_voiture;
    private $id_modele;
    private $couleur;
    private $immatriculation;
    private $disponible;

    public function __construct($id_voiture = null, $id_modele = null, $couleur = "", $immatriculation = "", $disponible = true) {
        $this->id_voiture = $id_voiture;
        $this->id_modele = $id_modele;
        $this->couleur = $couleur;
        $this->immatriculation = $immatriculation;
        $this->disponible = $disponible;
    }

    // Getters
    public function getIdVoiture() { return $this->id_voiture; }
    public function getIdModele() { return $this->id_modele; }
    public function getCouleur() { return $this->couleur; }
    public function getImmatriculation() { return $this->immatriculation; }
    public function isDisponible() { return $this->disponible; }

    // Setters
    public function setIdVoiture($id) { $this->id_voiture = $id; }
    public function setIdModele($id) { $this->id_modele = $id; }
    public function setCouleur($couleur) { $this->couleur = $couleur; }
    public function setImmatriculation($immatriculation) { $this->immatriculation = $immatriculation; }
    public function setDisponible($disponible) { $this->disponible = $disponible; }
}
