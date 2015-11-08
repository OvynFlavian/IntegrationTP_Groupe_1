<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 18/10/2015
 * Time: 11:26
 */
use \Entity\Activity as Activity;


function afficherMembres() {
    $um = new UserManager(connexionDb());
    $tab = $um ->getAllUser();
    ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Membres </h2></caption>
            <tr>
                <th> Nom d'utilisateur</th>
                <th> Dernière connexion</th>
                <th> Date d'inscription</th>
                <th> Voir le profil</th>
            </tr>
            <?php
            foreach ($tab as $elem) {
                $id = $elem->getId();
                if ($id != $_SESSION['User']->getId()) {
                    echo "<tr> <td>" . $elem->getUserName() . " </td><td>" . $elem->getDateLastConnect() . "</td><td>" . $elem->getDateInscription() . "</td>";
                    echo "<td><form class='form-horizontal col-sm-12' name='voirProfil' action='administration.page.php' method='post'>";
                    echo "<input type='hidden'  name='idMembre'  value='" . $id . "''>";
                    echo "<button class='btn btn-success col-sm-8' type='submit' id='formulaire' name='voirProfil'>Voir le profil</button>";
                    echo "</tr>";
                }
            }
            if ($tab == NULL) {
                echo "<tr> <td> Aucun utilisateur trouvé !</td></tr>";
            }
            ?>
        </table>
    </div>
    <?php
}

function voirProfil($id) {

    $um = new UserManager(connexionDb());
    $user = $um->getUserById($id);
    $droit = $user->getDroit()[0];
    $uam = new User_ActivityManager(connexionDb());
    $ua = $uam->getActIdByUserId($user);
    $am = new ActivityManager(connexionDb());
    if ($ua != NULL) {
        $activity = $am->getActivityById($ua[0]['id_activity']);
    } else {
        $activity = new Activity(array(
            "Libelle" => "Il n'a pas encore choisi d'activité !"
        ));
    }
    if ($user->getTel() == NULL) {
        $user->setTel("N/A");
    }
    echo "<h1> Les données de l'utilisateur :</h1>";
    echo "<div class='profil'><br>";
    echo " <b>Son pseudo : </b> ".$user->getUserName()."<br><br>";
    echo " <b>Son grade : </b>".$droit->getLibelle()."<br><br>";
    echo " <b>Son activité : </b> ".$activity->getLibelle()."<br><br>";
    echo " <b>Son adresse mail : </b> ".$user->getEmail()."<br><br>";
    echo " <b>Son numéro de téléphone : </b> ".$user->getTel()."<br><br>";
    echo " <b>Sa date de dernière connexion : </b> ".$user->getDateLastConnect()."<br><br>";
    if ($user->getDateLastIdea() == NULL) {
        $user->setDateLastIdea("N/A");
    }
    echo " <b>Sa date de dernière activité proposée : </b> ".$user->getDateLastIdea()."<br><br>";
    echo " <b>Sa date d'inscription : </b> ".$user->getDateInscription()."<br><br>";
    echo "</div><br><br>";
    echo "<div class='formProfil'>";
    echo "<form class='form-horizontal col-sm-12' name='choixAdmin' action='administration.page.php' method='post'>";
    echo "<input type='hidden'  name='idUser'  value='" . $user->getId() . "''>";
    echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='EnvoyerMess'>Envoyer un message</button>";
    echo "</form>";
    echo "</div>";
    echo "<div class='formGrade'>";
        formGrade($user->getId());
    echo "</div>";
}

function formGrade($id) {
    $dm = new DroitManager(connexionDb());
    $tabDroit = $dm->getAllDroit();
    echo "<h1> Modifier le grade de l'utilisateur </h1><br>";
    echo "<form class='form-horizontal col-sm-12' name='changerGrade' action='administration.page.php' method='post'>";
    echo "<select name='grade' id='grade'>";
    foreach($tabDroit as $elem) {
        if ($elem->getId() != 1 && $elem->getId() != 5)
        echo "<option value='". $elem->getId() ."'>". $elem->getLibelle() ."</option>";
    }
    echo "</select>";
    echo "<input type='hidden'  name='idUserGrade'  value='" . $id . "''>";
    echo "<br><br>";
    echo "<button class='btn btn-success col-sm-4' type='submit' id='formulaire' name='changerGrade'>Changer le grade</button>";

    echo "</form>";

}

function modifGrade() {
    $id = $_POST['idUserGrade'];
    $idGrade = $_POST['grade'];
    require "../Manager/User_DroitManager.manager.php";
    $udm = new User_DroitManager(connexionDb());
    $udm->modifDroit($id, $idGrade);
}
function modifConfig()
{
    if (isPostFormulaire()) {
        if (hash("sha256", $_POST['mdp']) == $_SESSION['User']->getMdp()) {
            $ini = getConfigFile();

            $fichier = fopen('../config.ini.php', 'w');

            $ini['CONSTANTE']['size_user_name'] = $_POST['size_user_name'];
            $ini['CONSTANTE']['size_user_name'] = $_POST['size_user_mdp'];
            $ini['ADMINISTRATEUR']['pseudo'] = $_POST['pseudo'];
            $ini['ADMINISTRATEUR']['mail'] = $_POST['mail'];
            $ini['ADMINISTRATEUR']['tel'] = $_POST['tel'];
            $ini['DATABASE']['password'] = "''";
            $ini['DOMAINE']['nom_domaine'] = $_POST['nom_domaine'];
            $ini['SERVEUR_ADDRESS']['web'] = $_POST['web'];
            $ini['SERVEUR_ADDRESS']['web'] = $_POST['bdd'];
            $ini['SERVEUR_ADDRESS']['web'] = $_POST['mail'];
            $newConfig = ';<?php echo "Acces refuse"; exit;?>' . "\n";
            foreach ($ini as $key => $value) {
                $newConfig .= '[' . $key . ']' . "\n";
                foreach ($value as $nom => $valeur) {
                    $newConfig .= "$nom = $valeur" . "\n";
                }
            }
            fputs($fichier, $newConfig);

            fclose($fichier);
            echo 'Config modifiée ! <br>';


            header("Location:administration.page.php?to=viewConfig");

        } else {

            return "Votre password actuel est faux, rééssayez !";

        }

    }

}