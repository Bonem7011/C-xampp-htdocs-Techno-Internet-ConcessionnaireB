<?php
class UtilisateurDAO {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    public function insert(Utilisateur $utilisateur) {
        $stmt = $this->db->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $utilisateur->getNom(),
            $utilisateur->getPrenom(),
            $utilisateur->getEmail(),
            password_hash($utilisateur->getMotDePasse(), PASSWORD_DEFAULT),
            $utilisateur->getTelephone(),
            $utilisateur->getRole()
        ]);
    }

    public function authenticate($email, $mot_de_passe) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($mot_de_passe, $row['mot_de_passe'])) {
            return new Utilisateur(
                $row['id_utilisateur'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['mot_de_passe'],
                $row['telephone'],
                $row['role']
            );
        }

        return null;
    }

    public function getUtilisateurByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Utilisateur(
                $row['id_utilisateur'],
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['mot_de_passe'],
                $row['telephone'],
                $row['role']
            );
        }

        return null;
    }
}
