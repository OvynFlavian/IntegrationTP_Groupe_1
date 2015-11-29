<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/11/2015
 * Time: 19:21
 */
use \Entity\Amis as Amis;
use \Entity\User as User;
use \Entity\Activity as Activity;
use \Entity\Groupe as Groupe;

function getDemandeToMe() {
    $am = new AmisManager(connexionDb());
    $tab = $am->getAmisByIdUser2($_SESSION['User']->getId());
    $um = new UserManager(connexionDb());
    $existe = true;
    ?>
    <div class="table-responsive">
         <table class="table table-striped">
             <caption> <h2> Membres </h2></caption>
             <tr>
                 <th> Nom d'utilisateur</th>
                 <th> Date </th>
                 <th> Validation </th>
             </tr>
    <?php
        foreach ($tab as $elem) {
            if ($elem->getAccepte() == 0) {
                $user = $um->getUserById($elem->getIdUser1());
                $id = $user->getId();
                echo "<tr> <td>" . $user->getUserName() . " </td><td>" . $elem->getDate() . " </td><td>";
                echo "<form class='form-horizontal col-sm-12' name='accepter$id' action='amis.page.php?to=friendList' method='post'>";
                echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='Accepter$id'>Accepter</button>";
                echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='Refuser$id'>Refuser</button>";
                echo "<input type='hidden'  name='idMembre$id'  value='" . $id . "''>";
                echo "</form>";
                echo "</td></tr>";
                $existe = false;
            }
        }
    if ($tab == NULL || $existe) {
        echo "<tr> <td> Aucune demande reçue !</td></tr>";
    }
    ?>
        </table>
    </div>
<?php
}
?>
<?php
function getDemandeToThem() {
    $am = new AmisManager(connexionDb());
    $tab = $am->getAmisByIdUser1($_SESSION['User']->getId());
    $um = new UserManager(connexionDb());
    $existe = true;
    ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Membres </h2></caption>
            <tr>
                <th> Nom d'utilisateur</th>
                <th> Date </th>
                <th> Validation </th>
            </tr>
    <?php
    foreach ($tab as $elem) {
        if ($elem->getAccepte() == 0) {
            $user = $um->getUserById($elem->getIdUser2());
            echo "<tr> <td>" . $user->getUserName() . " </td><td>" . $elem->getDate() . " </td><td> En cours de validation</td></tr>";
            $existe = false;
        }
    }
    if ($tab == NULL || $existe) {
        echo "<tr> <td> Aucune demande envoyée !</td></tr>";
    }
    ?>
        </table>
    </div>
<?php
}
?>
<?php
function gererDemande() {
    $um = new UserManager(connexionDb());
    $tabUser = $um->getAllUser();
    $trueId = 0;
    foreach ($tabUser as $elem) {
        $id = $elem->getId();
        if (isset($_POST['Accepter'.$id.''])){
            $trueId = $id;
        } else if (isset($_POST['Refuser'.$id.''])) {
            $trueId = $id;
        }
    }
    return $trueId;
}
?>
<?php
function gererValidation()
{
    $id = gererDemande();
    if (isset($_POST['Accepter'.$id.'']) || isset($_POST['Refuser'.$id.''])) {
        $am = new AmisManager(connexionDb());
        $idAmi = $_POST['idMembre'.$id.''];
        $demande = new Amis(array(
            "id_user_1" => $idAmi,
            "id_user_2" => $_SESSION['User']->getId(),
            "accepte" => 1,
        ));

        if (isset($_POST['Accepter'.$id.''])) {
            $am->updateAmisAccepte($demande);

        } else if (isset($_POST['Refuser'.$id.''])) {
            $am->deleteAmis($demande);
        }
    }
}


function verifIdAct() {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $am = new ActivityManager(connexionDb());
        $act = $am->getActivityById($id);
        if ($act->getLibelle() == NULL){
            return false;
        } else {
            return true;
        }
    }
}
function listeAmi() {
    $userId = $_SESSION['User']->getId();
    $am = new AmisManager(connexionDb());
    $tab1 = $am->getAmisByIdUser1($userId);
    $tab2 = $am->getAmisByIdUser2($userId);
    $tabRecap[0] = $tab1;
    $tabRecap[1] = $tab2;
    $um = new UserManager(connexionDb());
    $actm = new ActivityManager(connexionDb());
    $uam = new User_ActivityManager(connexionDb());
    $existe = false;
?>
    <div class="Membres">
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Membres </h2></caption>
            <tr>
                <th> Nom d'utilisateur</th>
                <th> Adresse Mail </th>
                <th> Téléphone </th>
                <th> Dernière connexion </th>
                <th> Activité du jour  </th>
                <th> Action  </th>
            </tr>
    <?php
    foreach ($tabRecap as $elem) {
        foreach ($elem as $amis) {
            if ($amis->getAccepte() == 1) {
                if ($elem == $tab1) {
                    $user = $um->getUserById($amis->getIdUser2());
                } else if ($elem == $tab2) {
                    $user = $um->getUserById($amis->getIdUser1());
                }

                $tabAct = $uam->getActIdByUserId($user);
                if ($tabAct) {
                    $actId = $tabAct[0]['id_activity'];
                    $activity = $actm->getActivityById($actId);
                    $activity->setLibelle("<a href='amis.page.php?to=modifAct&id=$actId'>" . $activity->getLibelle() . "</a>");
                } else {
                    $activity = new Activity(array(
                        "Libelle" => "N/A",
                    ));
                }
                if ($user->getTel() == NULL) {
                    $tel = "N/A";
                } else {
                    $tel = $user->getTel();
                }
                $id = $user->getId();
                echo "<tr><td>" . $user->getUserName() . " </td><td>" . $user->getEmail() . " </td><td> " . $tel . "</td><td> " . $user->getDateLastConnect() . "</td><td> " . $activity->getLibelle() . "</td>";
                echo "<td><form class='form-horizontal col-sm-12' name='suppression$id' action='amis.page.php' method='post'>";
                echo "<input type='hidden'  name='idAmi$id'  value='" . $id . "''>";
                echo "<button class='btn btn-danger col-sm-9' type='submit' id='formulaire' name='supprimerAmi$id'>Supprimer cet ami</button>";
                echo "</form>";
                echo "</td></tr>";
                $existe = true;
            }
        }
    }
    if (!$existe) {
        echo "<tr> <td> Vous n'avez pas d'ami pour le moment !</td></tr>";
    }
    ?>
        </table>
    </div>
    </div>
    <?php
}

function gererPost() {
    $um = new UserManager(connexionDb());
    $tabUser = $um->getAllUser();
    $trueId = 0;
    foreach ($tabUser as $elem) {
        $id = $elem->getId();
        if (isset($_POST['supprimerAmi'.$id.''])){
            $trueId = $id;
        }
    }
    return $trueId;
}
function gererSuppression($id) {
    if (isset($_POST['supprimerAmi'.$id.''])) {
        echo "<form class='form-horizontal col-sm-12' name='verifSupr' action='amis.page.php' method='post'>";
        echo "<h1 align='center'> Voulez-vous vraiment supprimer cet ami ? C'est irréversible !</h1><br>";
        echo "<input type='hidden'  name='idAmi'  value='" . $_POST['idAmi'.$id.''] . "''>";
        echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='AccepterSup'>Oui, je veux supprimer cet ami !</button>";
        echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='RefuserSup'>Je me suis trompé !</button>";
        echo "</form>";
    }
}

function gererReponseSup() {
    if (isset($_POST['AccepterSup'])) {
        $id = $_POST['idAmi'];
        supprimerAmi($id);
        echo "<h2 align='center'><div class='alert alert-danger' role='alert'>Cet ami ne fait dorénavant plus partie de votre liste d'amis !</div></h2>";
        echo "<meta http-equiv='refresh' content='1; URL=amis.page.php'>";
    } else if (isset($_POST['RefuserSup'])) {
        header("Location:amis.page.php");
    }
}

function supprimerAmi($id) {
    $am = new AmisManager(connexionDb());
    $friendToDelete1 = new Amis(array(
        "id_user_1" => $id,
        "id_user_2" => $_SESSION['User']->getId(),
    ));
    $friendToDelete2 = new Amis(array(
        "id_user_2" => $id,
        "id_user_1" => $_SESSION['User']->getId(),
    ));
    $am->deleteAmis($friendToDelete1);
    $am->deleteAmis($friendToDelete2);

}

function modifAct() {
    $id = $_GET['id'];
    $am = new ActivityManager(connexionDb());
    $activity = $am->getActivityById($id);
    echo "<div class='activity'>";
    echo "<img class='photoAct' src='../Images/activite/".$activity->getId().".jpg' alt='photoActivite' />";
    echo "<h1 style='text-align: center'>".$activity->getLibelle()."</h1>";
    echo "<h2 style='text-align: center'>".$activity->getDescription()."</h2>";
    if($activity->getNote() == NULL) {
        echo "<h3 style='text-align: center'>Cette activité n'a pas encore été notée !</h3>";
    } else {
        echo "<h3 style='text-align: center'>Sa note est de : ".$activity->getNote()."/5</h3>";
    }
    echo "<form class='form-horizontal col-sm-12' name='activite' action='amis.page.php?to=modifAct&id=$id' method='post'>";
    echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='AccepterAct'>Choisir cette activité</button>";
    echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='RefuserAct'>Je me suis trompé</button>";
    echo "</form>";
    echo "</div>";
}

function gererReponse()
{
    $id = $_GET['id'];
    if (isset($_POST['AccepterAct'])) {
        choixActivite($id);
    } else if (isset($_POST['RefuserAct'])) {
        header("Location: amis.page.php");
    }
}
function choixActivite($id) {
    if (isConnect()) {
        $uam = new User_ActivityManager(connexionDb());
        $tab = $uam->getActIdByUserId($_SESSION['User']);
        if (isset($tab[0]['id_activity'])) {
            echo "<br><br><h2 align='center'> <div class='alert alert-warning' role='alert'>Vous avez déjà une activité,<a href='amis.page.php?to=modifAct&id=$id&func=replace'> cliquez ici pour la remplacer</a>";
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
    require "../Manager/Groupe_InvitationManager.manager.php";
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
function modifActivite() {
    $act = $_GET['id'];
    $uam = new User_ActivityManager(connexionDb());
    $uam->deleteFromTable($_SESSION['User']);
    $activity = new Activity(array(
        "id" => $act,
    ));
    $uam->addToTable($activity, $_SESSION['User']);
    leaveGroupe();
    header('Location: ../');
}
function demande() {

?>
<article class="col-sm-12">
            <h1>Demande(s) d'amis en attente</h1>
            <?php
                getDemandeToMe();
            ?>
        </article>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <h1> Demande(s) d'amis envoyée(s)</h1>
            <?php
                getDemandeToThem();
            ?>
<h2 align="center">
</h2>
</article>
        <?php
}
        ?>
<?php


?>
