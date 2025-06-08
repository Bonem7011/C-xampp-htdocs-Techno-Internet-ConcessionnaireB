<?php
class Marque {
    private $id;
    private $nom;
    private $logo;

    public function __construct($id, $nom, $logo) {
        $this->id = $id;
        $this->nom = $nom;
        $this->logo = $logo;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getLogo() { return $this->logo; }
}
