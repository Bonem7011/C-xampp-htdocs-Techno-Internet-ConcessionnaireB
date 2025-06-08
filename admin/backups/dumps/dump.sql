-- TABLES

DROP TABLE IF EXISTS modele CASCADE;
DROP TABLE IF EXISTS voiture CASCADE;

CREATE TABLE modele (
                        id_modele SERIAL PRIMARY KEY,
                        nom_modele VARCHAR(100) NOT NULL
);

CREATE TABLE voiture (
                         id_voiture SERIAL PRIMARY KEY,
                         id_modele INTEGER REFERENCES modele(id_modele),
                         couleur VARCHAR(50),
                         immatriculation VARCHAR(20) UNIQUE NOT NULL,
                         disponible BOOLEAN DEFAULT TRUE
);

-- FONCTIONS

CREATE OR REPLACE FUNCTION get_all_voitures()
RETURNS TABLE (
    id_voiture INT,
    id_modele INT,
    couleur VARCHAR,
    immatriculation VARCHAR,
    disponible BOOLEAN
) AS $$
BEGIN
RETURN QUERY SELECT * FROM voiture;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION ajouter_voiture(
    p_id_modele INT,
    p_couleur VARCHAR,
    p_immatriculation VARCHAR,
    p_disponible BOOLEAN
)
RETURNS VOID AS $$
BEGIN
INSERT INTO voiture(id_modele, couleur, immatriculation, disponible)
VALUES (p_id_modele, p_couleur, p_immatriculation, p_disponible);
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION supprimer_voiture(p_id INT)
RETURNS VOID AS $$
BEGIN
DELETE FROM voiture WHERE id_voiture = p_id;
END;
$$ LANGUAGE plpgsql;

-- DONNÉES DE TEST

INSERT INTO modele (nom_modele) VALUES ('Clio'), ('Twingo'), ('Peugeot 208');

INSERT INTO voiture (id_modele, couleur, immatriculation, disponible) VALUES
                                                                          (1, 'Rouge', 'ABC-123', TRUE),
                                                                          (2, 'Bleu', 'XYZ-789', FALSE),
                                                                          (3, 'Noir', 'EEE-555', TRUE);
