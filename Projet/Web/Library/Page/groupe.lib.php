<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 20:41
 */
use \Entity\Groupe as Groupe;

function afficherMembres() {
    $um = new UserManager(connexionDb());
    $uam = new User_ActivityManager(connexionDb());
    $ugm = new User_GroupeManager(connexionDb());
    $act = $uam->getActIdByUserId($_SESSION['User']);
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
                                    if ($groupe != NULL) {
                                        echo "<td><a href='groupe.page.php?to=rejoindre&groupe=".$groupe[0]['id_groupe']."'> Rejoindre le groupe </a></td></tr>";
                                    } else {
                                        echo "<td><a href='groupe.page.php?to=ajouter&membre=$id'> Ajouter dans mon groupe </a></td></tr>";
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

function formCreerGroupe() {
    include "../Form/creerGroupe.form.php";
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
            $ugm = new User_GroupeManager(connexionDb());
            $gm->addGroupe($groupe);
            $groupeLead = $gm->getGroupeByLeader($_SESSION['User']);
            $ugm->addToUserGroupe($_SESSION['User'], $groupeLead);
            echo "<h1 align='center'><div class='alert alert-success' role='alert'> Le groupe a bien été créé !  </div></h1>";
            echo "<meta http-equiv='refresh' content='2; URL=groupe.page.php'>";
        } else {
            echo "<h1 align='center'><div class='alert alert-danger' role='alert'> Votre description contient des caractères indésirables !  </div></h1>";
        }
    }
}