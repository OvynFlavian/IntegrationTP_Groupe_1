<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:30
 */
use \Entity\Categorie as Categorie;
use \Entity\Activity as Activity;

function proposerActivite($cat) {

            $cm = new CategorieManager(connexionDb());
            $categorie = $cm->getCategorieByLibelle($cat);

            include "../Manager/Categorie_ActivityManager.manager.php";
            $cam = new Categorie_ActivityManager(connexionDb());

            $tabActivities = $cam->getActIdByCatId($categorie);
            $s = 0;
            $c = sizeof($tabActivities)-1;

            $idx=mt_rand($s, $c);
            $id = $tabActivities[$idx]['id_activity'];


            $am = new ActivityManager(connexionDb());
            $activity = $am->getActivityById($id);
            echo "<h1 style='text-align: center'>".$activity->getLibelle()."</h1>";

            include "../Form/proposerActivite.form.php" ;
}
function verifCat($cat) {
    $cm = new CategorieManager(connexionDb());
    $catVerif = $cm->getCategorieByLibelle($cat);
    if ($catVerif->getLibelle() != $cat) {
        return false;
    } else {
        return true;
    }

}
function gererReponse($cat)
{
    if (isset($_POST['Accepter'])) {
        header('Location: choisirCategorie.page.php');

    } else if (isset($_POST['Refuser'])) {
        header("Location: proposerActivite.page.php?categorie=" . $cat);
    }
}
