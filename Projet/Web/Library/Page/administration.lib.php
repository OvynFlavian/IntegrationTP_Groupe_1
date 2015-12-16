<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 18/10/2015
 * Time: 11:26
 */
use \Entity\Activity as Activity;
use \Entity\User as User;

/**
 * Fonction servant à aller rechercher en base de données les membres contenant le string fournit dans la barre de
 * recherche du site.
 * @return array : le tableau des membres présents en base de données avec ce string dans leur nom.
 */
function rechercheMembre()
{
    if (isPostFormulaire()) {
        $name = $_POST['userName'];

    } else {
        $name = "";
    }

    $um = new UserManager(connexionDb());
    $tab = $um->searchAllUserByName($name);
    return $tab;
}

/**
 * Fonction servant à afficher tous les membres présents dans un tableau donné. Il fournit aussi un lien permettant
 * de voir leur profil.
 * @param $tab : le tableau de membres.
 */
function afficherMembres($tab) {
    $existe = false;
    ?>
    <section class="Membres">
    <div class="table-responsive">
        <table class="table table-striped">
            <caption> <h2> Membres </h2></caption>
            <tr>
                <th> Nom d'utilisateur</th>
                <th> Dernière connexion</th>
                <th> Date d'inscription</th>
                <th> Action</th>
            </tr>
            <?php
            foreach ($tab as $elem) {
                $id = $elem->getId();
                if ($id != $_SESSION['User']->getId()) {
                    echo "<tr> <td>" . $elem->getUserName() . " </td><td>" . $elem->getDateLastConnect() . "</td><td>" . $elem->getDateInscription() . "</td>";
                    echo "<td><a href='administration.page.php?to=voirProfil&membre=$id'> Voir le profil </a></td></tr>";
                    $existe = true;
                }
            }
            if ($tab == NULL or !$existe) {
                echo "<tr> <td> Aucun utilisateur trouvé !</td></tr>";
            }
            ?>
        </table>
    </div>
    </section>
    <?php

}

/**
 * Fonction permettant de voir si le membre existe à l'aide d'une id fournie dans l'url.
 * @return bool : vrai si il existe, false si il n'existe pas.
 */
function checkMembre() {
    $id = $_GET['membre'];
    $um = new UserManager(connexionDb());
    $user = $um->getUserById($id);
    if ($user->getUserName() == NULL) {
        return false;
    } else {
        return true;
    }
}

/**
 * Fonction permettant d'afficher le profil d'un membre à l'aide de son id.
 * @param $id : l'id du membre voulu.
 */
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
    echo "<form class='form-horizontal col-sm-8' name='choixAdmin' action='administration.page.php' method='post'>";
    echo "<input type='hidden'  name='idUser'  value='" . $user->getId() . "''>";
    echo "<input type='hidden'  name='nameUser'  value='" . $user->getUserName() . "''>";
    echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='EnvoyerMess'>Envoyer un message</button>";
    echo "</form>";
    echo "</div>";
    echo "<div class='formGrade'>";
        formGrade($user);
    echo "</div>";
}

/**
 * Fonction générant un formulaire d'envoi de message à l'utilisateur pour l'admin.
 */
function formEnvoiMessage() {
    if (isset($_POST['EnvoyerMess'])) {
        $id = $_POST['idUser'];
        $name = $_POST['nameUser'];
        include "../Form/envoiMessageAdmin.form.php";
    }
}

/**
 * Fonction envoyant un message à l'adresse mail de l'utilisateur concerné.
 * @return string : le message de succès.
 */
function envoiMessage() {
    if (isset($_POST['formulaireEnvoi'])) {
        $id = $_POST['idUserMess'];
        $um = new UserManager(connexionDb());
        $userToSend = $um->getUserById($id);
        $adresseAdmin = "no-reply@everydayidea.be";
        $to = $userToSend->getEmail();
        $sujet = $_POST['titre'];
        $entete = "From:" . $adresseAdmin . "\r\n";
        $entete .= "Content-Type: text/html; charset=utf-8\r\n";
        $message = $_POST['description'];
        mail($to, $sujet, $message, $entete);
        return "<div class='alert alert-success' role='alert'> Message envoyé à l'utilisateur concerné ! </div>";
    }
}

/**
 * Fonction générant un formulaire permettant de changer le grade d'un utilisateur.
 * @param User $user : l'utilisateur dont le grade doit être changé.
 */
function formGrade(User $user) {
    $dm = new DroitManager(connexionDb());
    $tabDroit = $dm->getAllDroit();
    echo "<h1> Modifier le grade de l'utilisateur </h1><br>";
    echo "<form class='form-horizontal col-sm-12' name='changerGrade' action='administration.page.php' method='post'>";
    echo "<select name='grade' id='grade'>";
    foreach($tabDroit as $elem) {
        if ($elem->getId() != 1 && $elem->getId() != 5) {
           if ($elem->getId() == $user->getDroit()[0]->getId()) {
               echo "<option value='". $elem->getId() ."' selected>". $elem->getLibelle() ."</option>";

           } else {
               echo "<option value='". $elem->getId() ."'>". $elem->getLibelle() ."</option>";
           }
        }



    }

    echo "</select>";
    echo "<input type='hidden'  name='idUserGrade'  value='" . $user->getId() . "''>";
    echo "<br><br>";
    echo "<button class='btn btn-success col-sm-4' type='submit' id='formulaire' name='changerGrade'>Changer le grade</button>";

    echo "</form>";

}

/**
 * Fonction modifiant le grade d'un utilisateur en base de données.
 */
function modifGrade() {
    $id = $_POST['idUserGrade'];
    $idGrade = $_POST['grade'];
    require "../Manager/User_DroitManager.manager.php";
    $udm = new User_DroitManager(connexionDb());
    $udm->modifDroit($id, $idGrade);
}

/**
 * Fonction permettant de modifier le fichier de configuration du site.
 * @return string : le message d'erreur dans le cas où l'admin rentre un mauvais mot de passe.
 */
function modifConfig()
{
    if (isPostFormulaire()) {
        if (hash("sha256", $_POST['mdp'].$_SESSION['User']->getSalt()) == $_SESSION['User']->getMdp()) {
            $ini = getConfigFile();

            $fichier = fopen('../config.ini.php', 'w');
            $ini['CONSTANTE']['size_user_name'] = $_POST['size_user_name'];
            $ini['CONSTANTE']['size_user_name'] = $_POST['size_user_mdp'];
            $ini['ADMINISTRATEUR']['pseudo'] = $_POST['pseudo'];
            $ini['ADMINISTRATEUR']['mail'] = $_POST['mail'];
            $ini['ADMINISTRATEUR']['tel'] = $_POST['tel'];
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

            echo "<div class='alert alert-success' role='alert'> Config modifiée ! </div>";


            header("Location:administration.page.php?to=viewConfig");

        } else {

            return "<div class='alert alert-danger' role='alert'> Votre password actuel est faux, rééssayez ! </div>";

        }

    }

}