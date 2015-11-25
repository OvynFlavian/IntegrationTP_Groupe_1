<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 8/11/2015
 * Time: 02:00
 */
use \Entity\Activity as Activity;
function afficherActivite() {
    ?>
    <div class="Membres">
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Activités </h2></caption>
            <tr>
                <th> Nom de l'activité</th>
                <th> Nom de la catégorie</th>
                <th> Action </th>
            </tr>
            <?php
            $am = new ActivityManager(connexionDb());
            $cam = new Categorie_ActivityManager(connexionDb());
            $cm = new CategorieManager(connexionDb());
            $tab = $am->getAllActivity();
            $existe = false;
            foreach ($tab as $elem) {
                $id = $elem->getId();
                $catId = $cam->getCatIdByActId($elem);
                if (isset($catId[0]))
                $cat = $cm->getCategorieById($catId[0]['id_categorie']);
                    if ($elem->getSignalee() == 1) {
                        echo "<tr> <td>" . $elem->getLibelle() . " </td><td>" . $cat->getLibelle(). "</td><td><a href='proposerActivite.page.php?categorie=".$cat->getLibelle()."&activite=$id'> Gérer le signalement </a></td></tr>";
                        $existe = true;
                    }
            }
            if (!$existe) {
                echo "<tr> <td> Aucune activité signalée !</td></tr>";
            }
            ?>
        </table>
    </div>
    </div>
    <?php
}