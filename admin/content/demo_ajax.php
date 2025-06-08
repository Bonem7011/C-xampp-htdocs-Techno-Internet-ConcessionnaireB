<?php $dep = new DepartementDAO($cnx);
$liste_dep = $dep->getDepartements();
$nbr_dep = count($liste_dep);
//var_dump($liste_dep);
?>

<div id="liste" class="container">
    <div class="row">
        <div class="col-md-3">Département<br><br></div>
    </div>

    <?php for ($i = 0; $i < $nbr_dep; $i++) { ?>
        <div class="row">
            <div class="col-md-3"
                 id_dep="<?= $liste_dep[$i]->id_departement; ?>">
                <?php
                print $liste_dep[$i]->nom_departement . "<br><br>"; ?>
            </div>
        </div> <?php } ?> </div>

<div class="container" id="responsable">

</div>