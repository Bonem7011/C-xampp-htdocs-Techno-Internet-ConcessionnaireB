<?php
require_once("admin/src/php/utils/all_includes.php");
$dao = new MarqueDAO();
$marques = $dao->getAll();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#id_marque').change(function () {
            var id_marque = $(this).val();
            $.post("admin/src/php/ajax/get_modeles_par_marque.php", { id_marque: id_marque }, function (data) {
                $('#resultat_modeles').html(data);
            });
        });
    });
</script>

<div class="container mt-4">
    <h2>Modèles disponibles par marque</h2>
    <div class="mb-3">
        <label for="id_marque" class="form-label">Choisir une marque :</label>
        <select id="id_marque" class="form-select">
            <option value="">-- Sélectionnez --</option>
            <?php foreach ($marques as $marque): ?>
                <option value="<?= $marque['id'] ?>"><?= htmlspecialchars($marque['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div id="resultat_modeles" class="mt-4"></div>
</div>
