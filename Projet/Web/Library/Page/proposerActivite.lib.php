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
use \Entity\Groupe as Groupe;

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
                if (isConnect()) formSignalement($activity->getId(), $cat, $activity->getSignalee());
                echo "<div class='activity'>";
                if ($activity->getSignalee() == 1 ) echo "<h4 style='width:25%'><div class='alert alert-danger' role='alert'> Activité déjà signalée </div></h4>";
                echo "<h1 style='text-align: center'>" . $activity->getLibelle() . "</h1>";
                echo "<h2 style='text-align: center'>" . $activity->getDescription() . "</h2>";
                if ($activity->getNote() == NULL) {
                    echo "<h3 style='text-align: center'>Cette activité n'a pas encore été notée !</h3>";
                } else {
                    echo "<h3 style='text-align: center'>Sa note est de : " . $activity->getNote() . "/5</h3>";
                }

                include "../Form/proposerActivite.form.php";
                echo "</div>";
                return $id;

}

function formSignalement($id, $cat, $signalee) {

    echo "<form class='form-horizontal col-sm-12' name='formSignalement' action='proposerActivite.page.php?categorie=$cat&activite=$id&to=signaler' method='post'>";
    echo "<input type='hidden'  name='idAct'  value='" . $id . "''>";
    if ($signalee == 0) {
        echo "<button class='btn btn-danger col-sm-2' type='submit' id='formulaire' name='signaler'>Signaler cette activité</button>";
    } else {
        if ($_SESSION['User']->getDroit()[0]->getId() == 1 || $_SESSION['User']->getDroit()[0]->getId() == 2)
        echo "<button class='btn btn-success col-sm-2' type='submit' id='formulaire' name='designaler'>Enlever le signalement</button>";
    }
    if ($_SESSION['User']->getDroit()[0]->getId() == 1 || $_SESSION['User']->getDroit()[0]->getId() == 2)
    echo "<button class='btn btn-danger col-sm-2' type='submit' id='formulaire' name='supprimer'>Supprimer cette activité</button>";
    echo "</form>";

}

function gererSignalement() {
    if (isset($_POST['supprimer']) || isset($_POST['signaler']) || isset($_POST['designaler'])) {
        $do = '';
        if (isset($_POST['supprimer'])) {
            $do = 'supprimer';
        } else if (isset($_POST['signaler'])) {
            $do = 'signaler';
        } else if (isset($_POST['designaler'])) {
            $do = 'enlever le signalement de ';
        }

        $cat = $_GET['categorie'];
        $id = $_GET['activite'];
        echo "<div align='center'>";
        echo "<form class='form-horizontal col-sm-12' name='gererSignalement' action='proposerActivite.page.php?categorie=$cat&activite=$id&to=signaler' method='post'>";
        echo "<h1 align='center'>Êtes-vous sûr de vouloir $do l'activité ?</h1><br><br>";
        if ($do = 'supprimer') {
            echo "<h1 align='center'>Supprimer une activité supprime aussi tous les groupes liés à elle, pensez-y !</h1><br><br>";
        }
        echo "<input type='hidden'  name='idActivity'  value='" . $id . "''>";
        echo "<input type='hidden' name='reason' value='" . $do . "'>";
        echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='accepterSignal'>Oui, je suis sûr</button>";
        echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='refuserSignal'>Je me suis trompé</button>";
        echo "</form>";
        echo "</div>";
    }


}

function reponseSignalement() {
    if (isset($_POST['accepterSignal']) || isset($_POST['refuserSignal'])) {
        $do = $_POST['reason'];
        $id = $_POST['idActivity'];
        $cam = new Categorie_ActivityManager(connexionDb());
        $am = new ActivityManager(connexionDb());
        $uam = new User_ActivityManager(connexionDb());
        if (isset($_POST['accepterSignal'])) {
            if ($do == 'supprimer') {
                $do = 'supprimée';
                $gm = new GroupeManager(connexionDb());
                $ugm = new User_GroupeManager(connexionDb());
                $gmm = new Groupe_MessageManager(connexionDb());
                $gim = new Groupe_InvitationManager(connexionDb());
                $tabGroupe = $gm->getGroupeByIdActivity($id);
                foreach ($tabGroupe as $elem) {
                    $ugm->deleteGroupe($elem);
                    $gmm->deleteMessByGroupe($elem);
                    $gim->deleteInvitByGroupeId($elem);
                    $gm->deleteGroupe($elem->getIdLeader());
                }

                $cam->deleteFromTable($id);
               $uam->deleteActivity($id);
               $am->deleteActivity($id);

            } else if ($do == 'signaler') {
                $do = 'signalée';
                $am->signalementActivity($id, 1);
            } else if ($do == 'enlever le signalement de ') {
                    $do = 'désignalée';
                    $am = new ActivityManager(connexionDb());
                    $am->signalementActivity($id,0);
            }
            echo "<div class='alert alert-success' role='alert'> L'activité a été $do avec succès ! </div>";
            echo "<meta http-equiv='refresh' content='1; URL=choisirCategorie.page.php'>";
        } else if (isset($_POST['refuserSignal'])) {
            header('Location: choisirCategorie.page.php');
        }
    }
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
            echo "<h2 align='center'><div class='alert alert-warning' role='alert'> Vous avez déjà une activité,<a href='proposerActivite.page.php?categorie=$cat&activite=$id&to=modif'> cliquez ici pour la remplacer</a>";
             if (isLeader()) {
                echo "<br> Vous êtes chef d'un groupe, votre changement d'activité changera le chef du groupe ou le supprimera si vous êtes le seul membre";
            } else if (hasGroupe()) {
                echo "<br> Vous êtes dans un groupe, tout changement d'activité vous fera quitter ce groupe";
            }
            echo "</div></h2>";
        } else {
            $act = new Activity(array(
                "id" => $id,
            ));
            $uam->addToTable($act, $_SESSION['User']);
            header('Location: ../');
        }
    }

}

function hasGroupe() {
    if (isConnect()) {
        $ugm = new User_GroupeManager(connexionDb());
        $hasGroupe = $ugm->getGroupeIdByUserId($_SESSION['User']);
        if (isset($hasGroupe[0]['id_groupe'])) {
            return true;
        } else {
            return false;
        }

    }
}

function leaveGroupe() {
    $ugm = new User_GroupeManager(connexionDb());
    $gmm = new Groupe_MessageManager(connexionDb());
    $gim = new Groupe_InvitationManager(connexionDb());
    $idGr = $ugm->getGroupeIdByUserId($_SESSION['User']);
    if (isset($idGr[0]['id_groupe'])) {
        $groupe = new Groupe(array(
            "id_groupe" => $idGr[0]['id_groupe'],
        ));
        if (hasGroupe()) {
            $nom = $_SESSION['User']->getUserName();
            $desc = "L'utilisateur $nom a quitté le groupe suite à un changement d'activité.";
            $gmm->addMess($groupe, $_SESSION['User'], $desc);
            $ugm->deleteUserGroupe($_SESSION['User']);


        }
        if (isLeader()) {
            $autreMembre = false;
            $gm = new GroupeManager(connexionDb());
            $tabUser = $ugm->getUserIdByGroupeId($groupe);
            foreach($tabUser as $elem) {
                if ($elem['id_user'] != $_SESSION['User']->getId()) {
                    if (isset($elem['id_user']) && $elem['id_user'] != 0) {
                        $autreMembre = true;
                        $idNewLeader = $elem['id_user'];
                        $nom = $_SESSION['User']->getUserName();
                        $um = new UserManager(connexionDb());
                        $newLead = $um->getUserById($idNewLeader);
                        $userName = $newLead->getUserName();
                        $desc = "L'utilisateur $nom a quitté le groupe suite à un changement d'activité. $userName est dorénavant votre nouveau chef de groupe.";
                        $gmm->addMess($groupe, $_SESSION['User'], $desc);
                    }
                }
            }
            if ($autreMembre) {
                $gm->updateLeader($groupe, $idNewLeader);
            } else {

                $ugm->deleteGroupe($groupe);
                $gmm->deleteMessByGroupe($groupe);
                $gim->deleteInvitByGroupeId($groupe);
                $gm->deleteGroupe($_SESSION['User']->getId());
            }
        }
    }

}
function isLeader() {
    if (isConnect()) {
        $gm = new GroupeManager(connexionDb());
        $isLeader = $gm->getGroupeByLeader($_SESSION['User']);
        if ($isLeader->getDescription() != NULL) {
            return true;
        } else {
            return false;
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
    <div class="Membres">
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
        leaveGroupe();
        header('Location: ../');
    } else {
        header('Location: ../');
    }
}
