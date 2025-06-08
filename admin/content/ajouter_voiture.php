<?php


require_once(__DIR__ . '/../src/php/utils/all_includes.php');
require_once(__DIR__ . '/../src/php/utils/check_connection.php');

$db = getConnection();

// Récupérer les marques
$marques = $db->query("SELECT * FROM marque ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_voiture'])) {
    $id_marque = $_POST['id_marque'];
    $nom_modele = $_POST['nom_modele'];
    $motorisation = $_POST['motorisation'];
    $couleur = $_POST['couleur'];
    $immatriculation = $_POST['immatriculation'];
    $disponible = isset($_POST['disponible']) ? true : false;

    $image_nom = null;
    if (!empty($_FILES['image']['name'])) {
        $image_nom = basename($_FILES['image']['name']);
        $chemin_cible = __DIR__ . '/../assets/images/modeles/' . $image_nom;
        move_uploaded_file($_FILES['image']['tmp_name'], $chemin_cible);
    }

    // Ajouter le modèle
    $stmt = $db->prepare("INSERT INTO modele (nom_modele, id_marque, motorisation, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom_modele, $id_marque, $motorisation, $image_nom]);

    // Récupérer l'id du modèle nouvellement créé
    $id_modele = $db->lastInsertId('modele_id_modele_seq');

    // Ajouter la voiture
    $stmt2 = $db->prepare("INSERT INTO voiture (id_modele, couleur, immatriculation, disponible) VALUES (?, ?, ?, ?)");
    $stmt2->execute([$id_modele, $couleur, $immatriculation, $disponible]);

    setFlash("🚗 Voiture ajoutée avec succès !");
    header('Location: index_.php?page=admin_voitures.php');
    exit;
}
?>

<h1>Ajouter une voiture</h1>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="id_marque">Marque</label>
        <select name="id_marque" id="id_marque" class="form-control" required>
            <option value="">Choisir une marque</option>
            <?php foreach ($marques as $marque): ?>
                <option value="<?= $marque['id'] ?>"><?= htmlspecialchars($marque['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="nom_modele">Nom du modèle</label>
        <input type="text" name="nom_modele" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="motorisation">Motorisation</label>
        <input type="text" name="motorisation" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="image">Image du modèle</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="mb-3">
        <label for="couleur">Couleur</label>
        <input type="text" name="couleur" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="immatriculation">Immatriculation</label>
        <input type="text" name="immatriculation" class="form-control" required>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="disponible" class="form-check-input" id="disponible">
        <label for="disponible" class="form-check-label">Disponible</label>
    </div>

    <button type="submit" name="ajouter_voiture" class="btn btn-success">Ajouter</button>
</form>
