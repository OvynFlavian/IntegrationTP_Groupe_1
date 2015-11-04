<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:30
 */
use \Entity\Categorie as Categorie;
use \Entity\Activity as Activity;
use \Entity\User as User;

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
            echo "<h2 style='text-align: center'>".$activity->getDescription()."</h2>";
            if($activity->getNote() == NULL) {
                echo "<h3 style='text-align: center'>Cette activité n'a pas encore été notée !</h3>";
            } else {
                echo "<h3 style='text-align: center'>Sa note est de : ".$activity->getNote()."/5</h3>";
            }

            include "../Form/proposerActivite.form.php" ;
            return $id;
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
function gererReponse($cat, $idAct)
{
    if (isset($_POST['Accepter'])) {
        choixActivite($idAct, $cat);
    } else if (isset($_POST['Refuser'])) {
        header("Location: proposerActivite.page.php?categorie=" . $cat);
    } else if (isset ($_POST['Inscription'])) {
        header('Location: inscription.page.php');
    }
}

function choixActivite($id, $cat) {
    if (isConnect()) {
        $uam = new User_ActivityManager(connexionDb());
        $tab = $uam->getActIdByUserId($_SESSION['User']);
        if (isset($tab[0]['id_activity'])) {
            echo "<h2 align='center'> Vous avez déjà une activité, êtes vous sûr de vouloir la <a href='proposerActivite.page.php?categorie=$cat&act=$id&to=modif'>remplacer</a> ? </h2>";
        } else {
            $act = new Activity(array(
                "id" => $id,
            ));
            $uam->addToTable($act, $_SESSION['User']);
            header('Location: ../');
        }
    }

}

function modifActivite() {
    $act = $_GET['act'];
    $uam = new User_ActivityManager(connexionDb());
    $uam->deleteFromTable($_SESSION['User']);
    $activity = new Activity(array(
        "id" => $act,
    ));
    $uam->addToTable($activity, $_SESSION['User']);
    header('Location: ../');
}
