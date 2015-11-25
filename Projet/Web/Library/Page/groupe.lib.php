<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 20:41
 */
use \Entity\Groupe as Groupe;
use \Entity\User as User;

function afficherMembres() {
    $um = new UserManager(connexionDb());
    $uam = new User_ActivityManager(connexionDb());
    $ugm = new User_GroupeManager(connexionDb());
    $act = $uam->getActIdByUserId($_SESSION['User']);
    $groupeUser = $ugm->getGroupeIdByUserId($_SESSION['User']);
    $tab = $um ->getAllUser();
    $existant = false;
    ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Membres premium ayant la même activité que vous</h2></caption>
            <tr>
                <th> Nom d'utilisateur</th>
                <th> Dernière connexion</th>
                <th> Date d'inscription</th>
                <th> Action</th>
            </tr>
            <?php
            foreach ($tab as $elem) {
                $id = $elem->getId();
                $actUser = $uam->getActIdByUserId($elem);
                if ($id != $_SESSION['User']->getId()) {
                        if ($elem->getDroit()[0]->getId() == 3 || $elem->getDroit()[0]->getId() == 2 || $elem->getDroit()[0]->getId() == 1) {
                            if ($actUser != NULL) {
                                if ($actUser[0]['id_activity'] == $act[0]['id_activity']) {
                                    $groupe = $ugm->getGroupeIdByUserId($elem);
                                    echo "<tr> <td>" . $elem->getUserName() . " </td><td>" . $elem->getDateLastConnect() . "</td><td>" . $elem->getDateInscription() . "</td>";
                                    if ($groupeUser != NULL && dejaInvite($id, $groupeUser[0]['id_groupe'])) {
                                        echo "<td> Cette personne a déjà été invitée dans votre groupe !</td></tr>";
                                    } else if ($groupeUser != NULL && sameGroupe($elem, $groupeUser[0]['id_groupe'])) {
                                        echo "<td> Cette personne est déjà dans votre groupe !</td></tr>";
                                    } else if ($groupe != NULL && hasGroupe()) {
                                        echo "<td> Cette personne est déjà dans un groupe, tout comme vous !</td></tr>";
                                    } else if ($groupe != NULL) {
                                        echo "<td><a href='groupe.page.php?to=rejoindre&groupe=" . $groupe[0]['id_groupe'] . "'> Rejoindre le groupe </a></td></tr>";
                                    } else if (hasGroupe()) {
                                        echo "<td><a href='groupe.page.php?to=ajouter&membre=$id'> Ajouter dans mon groupe </a></td></tr>";
                                    } else {
                                        echo "<td> Vous n'avez pas de groupe, tout comme la personne !</td></tr>";
                                    }
                                    $existant = true;
                                }

                            }
                        }

                }
            }
            if ($tab == NULL || !$existant) {
                echo "<tr> <td> Aucun utilisateur trouvé !</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php

}
function afficherInvitation() {
    $gim = new Groupe_InvitationManager(connexionDb());
    $invit = $gim->getInvitationByDemande($_SESSION['User']);
    $um = new UserManager(connexionDb());
    $gm = new GroupeManager(connexionDb());
    $existe = true;
    ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <caption> <h2> Invitations de groupe </h2></caption>
                <tr>
                    <th> Utilisateur envoyant l'invitation</th>
                    <th> Description du groupe </th>
                    <th> Validation </th>
                </tr>
                <?php
                foreach ($invit as $elem) {
                    $user = $um->getUserById($elem['id_user_envoi']);
                    $groupe = $gm->getGroupeByIdGroupe($elem['id_groupe']);
                    $id = $groupe->getIdGroupe();
                    echo "<tr> <td>" . $user->getUserName() . " </td><td>" . $groupe->getDescription() . " </td><td>";
                    echo "<form class='form-horizontal col-sm-12' name='accepter$id' action='groupe.page.php?to=invitation&action=gerer' method='post'>";
                    echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='AccepterGroupe$id'>Accepter</button>";
                    echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='RefuserGroupe$id'>Refuser</button>";
                    echo "<input type='hidden'  name='groupe$id'  value='" . $id . "''>";
                    echo "</form>";
                    echo "</td></tr>";
                    $existe = false;
                    }

                if ($invit == NULL || $existe) {
                    echo "<tr> <td> Aucune invitation reçue !</td></tr>";
                }
                ?>
            </table>
        </div>
        <?php

}

function gererReponseGroupe() {
    if (isset($_POST['modifier'])) {
        include "../Form/modifierDescription.form.php";
    } else if (isset($_POST['delete'])) {
       include "../Form/formDeleteGroupe.form.php";
    } else if (isset($_POST['leave'])) {
        include "../Form/formLeaveGroupe.form.php";
    }
}

function gererActionGroupe() {
    $gm = new GroupeManager(connexionDb());
    $ugm = new User_GroupeManager(connexionDb());
    $gmm = new Groupe_MessageManager(connexionDb());
    if (isset($_POST['Refuser'])) {
        header("Location:groupe.page.php?to=voirGroupe");
    } else if (isset($_POST['AccepterSupprimer'])) {
        $groupe = $gm->getGroupeByLeader($_SESSION['User']);
        $ugm->deleteGroupe($groupe);
        $gmm->deleteMessByGroupe($groupe);
        $gm->deleteGroupe($_SESSION['User']->getId());
        header("Location:groupe.page.php");
    } else if (isset($_POST['AccepterLeave'])) {
        $ugm->deleteUserGroupe($_SESSION['User']);
        header("Location:groupe.page.php");
    } else if (isset($_POST['modifierDesc'])) {
        $groupe = $gm->getGroupeByLeader($_SESSION['User']);
        $gm->updateGroupeDesc($groupe, $_POST['descriptionGroupe']);
        header("Location:groupe.page.php?to=voirGroupe");
    }
}

function voirGroupe() {
    $ugm = new User_GroupeManager(connexionDb());
    $groupeId = $ugm->getGroupeIdByUserId($_SESSION['User']);
    $gm = new GroupeManager(connexionDb());
    $am = new ActivityManager(connexionDb());
    $um = new UserManager(connexionDb());
    $amiM = new AmisManager(connexionDb());
    $gmm = new Groupe_MessageManager(connexionDb());
    $groupe = $gm->getGroupeByIdGroupe($groupeId[0]['id_groupe']);
    $leader = $um->getUserById($groupe->getIdLeader());
    $act = $am->getActivityById($groupe->getIdActivity());
    $membres = $ugm->getUserIdByGroupeId($groupe);
    $messages = $gmm->getMessageByGroup($groupe);
    $existe = false;
    formGroupe($groupe);
    echo "<div class='titleGroupe'>";
    echo "<h1 align='center'> Groupe concernant l'activité : ".$act->getLibelle()."</h1>";
    echo "<h2 align='center'> Chef de groupe : ".$leader->getUserName()."</h2>";
    echo "</div>";
    echo "<h3 align='center'> Description de votre activité :</h3>";

    echo "<div class='well well-lg'><h4 align='center'>".$act->getDescription() ."</h4></div>";
    echo "<h3 align='center'> Description de votre groupe : </h3>";

        echo "<div class='well well-lg'><h3 align='center'>" . $groupe->getDescription() . " </h3></div>";

    ?>
    <div class="table-responsive">
    <table class="table table-striped">
        <caption> <h2> Membres du groupe </h2></caption>
        <tr>
            <th> Utilisateur </th>
            <th> Date de dernière connexion</th>
            <th> Ajouter en ami </th>
        </tr>
        <?php
        foreach ($membres as $elem) {
            $user = $um->getUserById($elem['id_user']);
            if ($user->getId() != $_SESSION['User']->getId()) {
                $amiTest1 = $amiM->getAmisById1AndId2($user->getId(), $_SESSION['User']->getId());
                $amiTest2 = $amiM->getAmisById1AndId2($_SESSION['User']->getId(), $user->getId());
                echo "<tr> <td>" . $user->getUserName() . " </td><td>" . $user->getDateLastConnect() . " </td><td>";
                if ($amiTest1->getIdUser1() == NULL && $amiTest2->getIdUser1() == NULL) {
                    echo "<a href='demandeAmi.page.php?membre=" . $user->getId() . "'> Ajouter comme ami </a>";
                } else {
                    echo "Vous êtes déjà ami avec cette personne !";
                }
                echo "</td></tr>";
            }
        }
        ?>
    </table>
    </div>
    <?php
    echo "<br> <br>";
    echo "<h2> Messagerie du groupe : </h2><br>";
    echo "<div class='messagerieGroupe'>";
    include "../Form/groupeMessage.form.php";
    echo "<br>";
    ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th> Utilisateur</th>
                <th> Date </th>
                <th> Message </th>
            </tr>
            <?php
            foreach ($messages as $elem) {
                $user = $um->getUserById($elem['id_user']);
                echo "<tr> <td>" . $user->getUserName() . " </td><td>" . $elem['date'] . " </td><td>";
                echo $elem['description'];
                echo "</td></tr>";
                $existe = false;
            }

            if ($messages == NULL || $existe) {
                echo "<tr> <td> Aucun message pour le moment !</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php
    echo "</div>";

}

function envoiMessage() {
    if (isset($_POST['poster'])) {
        if (champsTexteValable($_POST['description'])) {
            if (strlen($_POST['description']) >= 2) {
                $gmm = new Groupe_MessageManager(connexionDb());
                $ugm = new User_GroupeManager(connexionDb());
                $groupeId = $ugm->getGroupeIdByUserId($_SESSION['User']);
                $groupe = new Groupe(array(
                    "id_groupe" => $groupeId[0]['id_groupe'],
                ));
                $gmm->addMess($groupe, $_SESSION['User'], $_POST['description']);
                header("Location:groupe.page.php?to=voirGroupe");
            } else {
                echo "<h1 align='center'><div class='alert alert-danger' role='alert'> Votre message est trop court !  </div></h1>";
            }
        } else {
            echo "<h1 align='center'><div class='alert alert-danger' role='alert'> Votre message contient des caractères indésirables !  </div></h1>";
        }
    }

}
function gererFormInvitation() {
    $gm = new GroupeManager(connexionDb());
    $tabGroupe = $gm->getAllGroupe();
    $trueId = 0;
    foreach ($tabGroupe as $elem) {
        $id = $elem->getIdGroupe();
        if (isset($_POST['AccepterGroupe'.$id.''])){
            $trueId = $id;
        } else if (isset($_POST['RefuserGroupe'.$id.''])) {
            $trueId = $id;
        }
    }
    return $trueId;
}

function gererReponseInvitation() {
    $id = gererFormInvitation();
    if (isset($_POST['AccepterGroupe'.$id.'']) || isset($_POST['RefuserGroupe'.$id.''])) {
        $gim = new Groupe_InvitationManager(connexionDb());
        $ugm = new User_GroupeManager(connexionDb());
        $groupe = new Groupe(array(
            "id_groupe" => $id,
        ));


        if (isset($_POST['AccepterGroupe'.$id.''])) {
            $ugm->addToUserGroupe($_SESSION['User'], $groupe);
            $gim->deleteInvitByUserId($_SESSION['User']);
            header("Location:groupe.page.php?to=voirGroupe");
        } else if (isset($_POST['RefuserGroupe'.$id.''])) {
            $gim->deleteInvitByGroupeIdAndUserId($groupe, $_SESSION['User']);
            header("Location:groupe.page.php?to=invitation");
        }
    }
}

function hasActivity() {
    $uam = new User_ActivityManager(connexionDb());
    $act = $uam->getActIdByUserId($_SESSION['User']);
    if ($act == NULL) {
        return false;
    } else {
        return true;
    }

}

function hasGroupe() {
    $ugm = new User_GroupeManager(connexionDb());
    $groupe = $ugm->getGroupeIdByUserId($_SESSION['User']);
    if ($groupe == NULL) {
        return false;
    } else {
        return true;
    }
}

function isInGroupe($id) {
    $ugm = new User_GroupeManager(connexionDb());
    $user = new User(array(
        "id" => $id,
    ));
    $groupe = $ugm->getGroupeIdByUserId($user);
    if ($groupe == NULL) {
        return false;
    } else {
        return true;
    }
}

function formCreerGroupe() {
    include "../Form/creerGroupe.form.php";
}

function formRejoindreGroupe() {
    include "../Form/rejoindreGroupe.form.php";
}
function formAjouter() {
    $id = $_GET['membre'];
    $ugm = new User_GroupeManager(connexionDb());
    $groupe = $ugm->getGroupeIdByUserId($_SESSION['User']);
    if (!dejaInvite($id, $groupe[0]['id_groupe'])) {
        include "../Form/demandeGroupe.form.php";
    } else {
        header("Location:groupe.page.php");
    }
}

function envoiInvitation() {
    if (isset($_POST['Accepter']) || isset($_POST['Refuser'])) {
        $id = $_GET['membre'];
        $ugm = new User_GroupeManager(connexionDb());
        $groupe = $ugm->getGroupeIdByUserId($_SESSION['User']);
        $gim = new Groupe_InvitationManager(connexionDb());
            if (isset($_POST['Accepter'])) {
                $gim->addInvit($id, $_SESSION['User']->getId(), $groupe[0]['id_groupe']);
                echo "<h1 align='center'><div class='alert alert-success' role='alert'> Votre demande a bien été envoyée !  </div></h1>";
                echo "<meta http-equiv='refresh' content='2; URL=groupe.page.php'>";
            } else if (isset($_POST['Refuser'])) {
                header("Location:groupe.page.php");
            }

    }
}

function isPremium() {
    $id = $_GET['membre'];
    $um = new UserManager(connexionDb());
    $userDroit = $um->getUserById($id);
    if ($userDroit->getDroit()[0]->getLibelle() == 'Premium' || $userDroit->getDroit()[0]->getLibelle() == 'Administrateur' || $userDroit->getDroit()[0]->getLibelle() == 'Moderateur') {
        return true;
    } else {
        return false;
    }
}

function sameGroupe(User $user, $idGroupe) {
    $ugm = new User_GroupeManager(connexionDb());
    $groupe = $ugm->getGroupeIdByUserId($user);
    if ($groupe != NULL && $groupe[0]['id_groupe'] == $idGroupe) {
        return true;
    } else {
        return false;
    }
}

function groupeExiste() {
    $id=$_GET['groupe'];
    $gm = new GroupeManager(connexionDb());
    $groupe = $gm->getGroupeByIdGroupe($id);
    if ($groupe->getDescription() == NULL) {
        return false;
    } else {
        return true;
    }

}

function groupeSameActivity() {
    $id = $_GET['groupe'];
    $gm = new GroupeManager(connexionDb());
    $groupe = $gm->getGroupeByIdGroupe($id);
    $uam = new User_ActivityManager(connexionDb());
    $act = $uam->getActIdByUserId($_SESSION['User']);
    if ($act[0]['id_activity'] == $groupe->getIdActivity()) {
        return true;
    } else {
        return false;
    }
}

function sameActivity($idUser) {
    $uam = new User_ActivityManager(connexionDb());
    $user = new User(array(
        "id" => $idUser,
    ));
    $activityUser = $uam->getActIdByUserId($user);
    $activityToCompare = $uam->getActIdByUserId($_SESSION['User']);
    if ($activityUser[0]['id_activity'] == $activityToCompare[0]['id_activity']) {
        return true;
    } else {
        return false;
    }
}

function dejaInvite($idUser, $idGroupe) {
    $gim = new Groupe_InvitationManager(connexionDb());
    $existe = false;
    $groupe = new Groupe(array(
        "id_groupe" => $idGroupe,
    ));
    $invit = $gim->getInvitationByGroupe($groupe);
    foreach ($invit as $elem) {
        if ($elem['id_user_demande'] == $idUser) {
            $existe = true;
        }
    }
    if ($existe) {
        return true;
    } else {
        return false;
    }
}
function rejoindreGroupe() {
    if (isset($_POST['AccepterRejoindre']) || isset($_POST['RefuserRejoindre'])) {
        $id = $_GET['groupe'];
        $groupe = new Groupe(array(
            "id_groupe" => $id,
        ));
        $gim = new Groupe_InvitationManager(connexionDb());
        $ugm = new User_GroupeManager(connexionDb());

        if (isset($_POST['AccepterRejoindre'])) {
            $gim->deleteInvitByUserId($_SESSION['User']);
            $ugm->addToUserGroupe($_SESSION['User'], $groupe);
            echo "<h1 align='center'><div class='alert alert-success' role='alert'> Vous avez bien rejoint le groupe !  </div></h1>";
            echo "<meta http-equiv='refresh' content='2; URL=groupe.page.php'>";
        } else if (isset($_POST['RefuserRejoindre'])) {
            header("Location:groupe.page.php");
        }

    }
}
function creerGroupe() {
    if (isset($_POST['formulaireCreation'])) {
        $desc = $_POST['description'];
        if (champsTexteValable($desc)) {
            $groupe = new Groupe(array(
                "id_leader" => $_SESSION['User']->getId(),
                "description" => $_POST['description'],
                "id_activity" => $_POST['idAct'],
            ));
            $gm = new GroupeManager(connexionDb());
            $gim = new Groupe_InvitationManager(connexionDb());
            $gim->deleteInvitByUserId($_SESSION['User']);
            $ugm = new User_GroupeManager(connexionDb());
            $gm->addGroupe($groupe);
            $groupeLead = $gm->getGroupeByLeader($_SESSION['User']);
            $ugm->addToUserGroupe($_SESSION['User'], $groupeLead);
            echo "<h1 align='center'><div class='alert alert-success' role='alert'> Le groupe a bien été créé !  </div></h1>";
            echo "<meta http-equiv='refresh' content='2; URL=groupe.page.php?to=voirGroupe'>";
        } else {
            echo "<h1 align='center'><div class='alert alert-danger' role='alert'> Votre description contient des caractères indésirables !  </div></h1>";
        }
    }
}