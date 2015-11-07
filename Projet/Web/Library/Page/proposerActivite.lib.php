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
    $am = new ActivityManager(connexionDb());
            if (isset($_GET['activite'])) {
                $id = $_GET['activite'];
                $activity = $am->getActivityById($id);
            } else {
                $cm = new CategorieManager(connexionDb());
                $categorie = $cm->getCategorieByLibelle($cat);

                $cam = new Categorie_ActivityManager(connexionDb());

                $tabActivities = $cam->getActIdByCatId($categorie);
                $s = 0;
                $c = sizeof($tabActivities) - 1;

                $idx = mt_rand($s, $c);
                $id = $tabActivities[$idx]['id_activity'];


                $activity = $am->getActivityById($id);
            }
                echo "<h1 style='text-align: center'>" . $activity->getLibelle() . "</h1>";
                echo "<h2 style='text-align: center'>" . $activity->getDescription() . "</h2>";
                if ($activity->getNote() == NULL) {
                    echo "<h3 style='text-align: center'>Cette activité n'a pas encore été notée !</h3>";
                } else {
                    echo "<h3 style='text-align: center'>Sa note est de : " . $activity->getNote() . "/5</h3>";
                }

                include "../Form/proposerActivite.form.php";
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
            echo "<h2 align='center'> Vous avez déjà une activité,<a href='proposerActivite.page.php?categorie=$cat&activite=$id&to=modif'> cliquez ici pour la remplacer</a> </h2>";
        } else {
            $act = new Activity(array(
                "id" => $id,
            ));
            $uam->addToTable($act, $_SESSION['User']);
            header('Location: ../');
        }
    }

}
function verifIdAct() {
    if (isset($_GET['activite'])) {
        $id = $_GET['activite'];
        $am = new ActivityManager(connexionDb());
        $act = $am->getActivityById($id);
        if ($act->getLibelle() == NULL){
            return false;
        } else {
            return true;
        }
    }
}

function rechercheActivite()
{
    $cat = $_GET['categorie'];
    $cm = new CategorieManager(connexionDb());
    $catId = $cm->getCategorieByLibelle($cat);
    $cam = new Categorie_ActivityManager(connexionDb());
    $tabId = $cam->getActIdByCatId($catId);
    if (isPostFormulaire()) {
        $name = $_POST['activite'];

    } else {
        $name = "";
    }

    $am = new ActivityManager(connexionDb());
    $tabAct = $am->searchAllActivityByLibelle($name);
    $tab = array();
    $i = -1;
    foreach ($tabAct as $elem) {
        $i++;
        foreach ($tabId as $act) {
            if ($elem->getId() == $act['id_activity']) {
                $tab[$i]=$elem;
            }
        }
    }

    return $tab;
}

function afficherActivites($tab, $cat) {
    ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Activités </h2></caption>
            <tr>
                <th> Nom de l'activité</th>
                <th> Description </th>
                <th> Note </th>
                <th> Action </th>
            </tr>
            <?php
            foreach ($tab as $elem) {
                if ($elem->getNote() == NULL) {
                    $elem->setNote("N/A");
                }
                $id = $elem->getId();
                echo "<tr> <td>" . $elem->getLibelle() . " </td><td>" . $elem->getDescription() . "</td><td>" . $elem->getNote() . "</td><td><a href='proposerActivite.page.php?categorie=$cat&activite=$id'> Choisir cette activité</a></td></tr>";
            }
            if ($tab == NULL) {
                echo "<tr> <td> Aucune activité trouvée !</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php
}

function modifActivite() {
    if (verifIdAct()) {
        $act = $_GET['activite'];
        $uam = new User_ActivityManager(connexionDb());
        $uam->deleteFromTable($_SESSION['User']);
        $activity = new Activity(array(
            "id" => $act,
        ));
        $uam->addToTable($activity, $_SESSION['User']);
        header('Location: ../');
    } else {
        header('Location: ../');
    }
}
