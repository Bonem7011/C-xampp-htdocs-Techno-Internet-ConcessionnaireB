<?php
//récupération des données
$title = "Nouvelle mission";
$pays = new PaysDAO($cnx);
$liste_p = $pays->getPays();
$nbr_p = 0;
$nbr_v = 0;
$pays_choisi = "";
if ($liste_p != NULL) {
    $nbr_p = count($liste_p);
}
//vérifier envoi du form première liste
if(isset($_GET['submit_pays'])){
    $villes = new VilleDAO($cnx);
    $liste_v = $villes->getVillesByIdPays($_GET['id_pays']);
    $pays_choisi = $liste_v[0]->nom_pays;
    //var_dump($liste_v);
}

if(isset($_GET['submit_ville'])){
    $localis = $pays->getLocalisation($_GET['id_ville']);
    //var_dump($localis);
    $localisation = '<div class="txtGras">';
    $localisation.= $localis[0]['nom_pays']. "  ".$localis[0]['nom_ville'];
    $localisation.= '</div>';


}

?>
<div id="selection">
    <div id="nom_pays">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
            <select id="id_pays" name="id_pays">
                <option value="">Pays</option>
                <?php
                if ($pays_choisi != "") {
                    ?>
                    <option value="<?= $pays_choisi; ?>" selected="selected"><?= $pays_choisi; ?></option>
                    <?php
                }
                foreach ($liste_p as $p) {
                    ?>
                    <option value="<?php print $p->id_pays; ?>">
                        <?php print $p->nom_pays; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <input type="submit" value="Pays" name="submit_pays" id="submit_pays"> &nbsp;&nbsp;&nbsp;
        </form>
    </div>

    <div id="choix_ville_sans_ajax">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" id="form_select_ville">
            <div id="no_ajax">
                <select id="id_ville" name="id_ville">
                    <option value="">Ville/région</option>
                    <?php
                    foreach ($liste_v as $v) {
                        ?>
                        <option value="<?= $v->id_ville; ?>">
                            <?php print $v->nom_ville; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
                <input type="submit" value="Ville" name="submit_ville" id="submit_ville">
            </div>
            <div id="choix_ville"></div>
        </form>
    </div>
</div>

<?php
//si pas de javascript
if (isset($nom_pays) && isset($nom_ville)) {
    ?>
    <div id="localisation">
        <span id="nom_pays" class="localisation"><?php print $nom_pays; ?></span>
        <span id="nom_pays" class="localisation"><?php print $nom_ville; ?></span>
    </div>
    <?php
}

if(isset($localisation)){
    print $localisation;
}
?>
<!--  JavaScript uniquement : -->
<div id="localisation_js"></div>
<?php
    if (isset($_GET['id_ville'])) {
    ?>
    <form id="form_ajout_mission" method="post" action="<?= $_SERVER['PHP_SELF'] ?>" >
        <div class="container form_nouvelle_mission" id="nouvelle_mission">
            <div class="row" id="zone_id_mission">
                <div class="col-md-3 offset-2">
                <span class="txtGras">Numéro de mission<span>
                </div>
                <div class="col-md-3">
                    <input type="number" name="id_mission" id="id_mission" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-2">
                <span class="txtGras">Dénomination<span>
                </div>
                <div class="col-md-3">
                    <input type="text" name="nom_mission" id="nom_mission" placeholder="Nom de la mission">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-2">
                    <span class="txtGras">Début de la mission</span>
                </div>
                <div class="col-md-3">
                    <input type="date" name="debut_mission" id="debut_mission" placeholder="Début">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-2">
                    <span class="txtGras">Fin</span>
                </div>
                <div class="col-md-3">
                    <input type="date" name="fin_mission" id="fin_mission" placeholder="Fin estimée">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-2">
                    <span class="txtGras">Description</span>
                </div>
                <div class="col-md-3">
                <textarea cols="50" rows="3" name="description_mission" id="description_mission"
                          placeholder="Origine de la mission"></textarea>
                </div>
            </div>
            <div class="row" id="zone_rapport">
                <div class="col-md-3 offset-2">
                    <span class="txtGras">Rapport de mission</span>
                </div>
                <div class="col-md-3">
                <textarea cols="50" rows="3" name="rapport_mission" id="rapport_mission"
                          placeholder="Rapport de mission"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 offset-2">
                    <input type="hidden" name="id_ville" id="id_ville" value="<?= $_GET['id_ville']; ?>">
                    <input type="reset" id="reset_mission" value="Annuler">
                    <input type="submit" id="submit_mission" name="submit_mission" value="Ajouter">
                </div>
            </div>
        </div>
    </form>
<?php
}


