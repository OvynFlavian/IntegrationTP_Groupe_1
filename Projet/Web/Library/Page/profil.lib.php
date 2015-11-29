<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 18:01
 */
use \Entity\User as User;
use \Entity\Activity as Activity;
require "../Manager/User_ActivityManager.manager.php";
/**
 * Fonction affichant le profil du membre connecté.
 */
function afficherProfil() {
    $user = $_SESSION['User'];
    $droit = $user->getDroit()[0];
    $uam = new User_ActivityManager(connexionDb());
    $ua = $uam->getActIdByUserId($user);
    $am = new ActivityManager(connexionDb());
    if ($ua != NULL) {
        $activity = $am->getActivityById($ua[0]['id_activity']);
    } else {
        $activity = new Activity(array(
            "Libelle" => "Vous n'avez pas encore choisi d'activité ! <a href='choisirCategorie.page.php'><b> Choisir une activité </b></a>"
        ));
    }
    if ($user->getTel() == NULL) {
        $user->setTel("N/A");
    }
    echo "<h1> Vos données d'utilisateur :</h1>";
    echo "<div class='profil'><br>";
    echo " <b>Votre pseudo : </b> ".$user->getUserName()."<br><br>";
    echo " <b>Votre grade : </b> ".$droit->getLibelle()."<br><br>";
    echo " <b>Votre activité : </b> ".$activity->getLibelle()."<br><br>";
    echo " <b>Votre adresse mail : </b> ".$user->getEmail()."<br><br>";
    echo " <b>Votre numéro de téléphone : </b> ".$user->getTel()."<br><br>";
    echo " <b>Votre date de dernière connexion : </b> ".$user->getDateLastConnect()."<br><br>";
    if ($user->getDateLastIdea() == NULL) {
        $user->setDateLastIdea("N/A");
    }
    echo " <b>Votre date de dernière activité proposée : </b> ".$user->getDateLastIdea()."<br><br>";
    echo " <b>Votre date d'inscription : </b> ".$user->getDateInscription()."<br><br>";
    echo "</div>";
}

/**
 * Fonction permettant de vérifier si le formulaire de modification de profil est correct et si il ne contient pas d'erreurs.
 * @param User $user : l'utilisateur qui a fait la demande de changement de profil.
 * @return array : un tableau contenant tous les messages d'erreur liés au formulaire de changement de profil ou un booleen
 * si le formulaire est correct.
 */
function isValidForm(User $user)
{
    $config = getConfigFile()['CONSTANTE'];
    $UserName = $_POST['userName'];
    $Email = $_POST['email'];
    $Mdp = $_POST['Mdp'];
    $MdpBis = $_POST['MdpBis'];
    $tel = $_POST['Tel'];
    $MdpActuel = $_POST['MdpActuel'];
    if ($Mdp == '') {
        $Mdp = NULL;
        $MdpBis = NULL;
    }
    $userTest = new User(array(
        "UserName" => $UserName,
        "email" => $Email,
        "Mdp" => $Mdp,
        "tel" => $tel,
    ));

    $tab = array("RETURN" => false, "ERROR" => array());
    $nameValable = false;
    $emailValable = false;
    $mdpValable = false;
    $nameExistant = false;
    $mailExistant = false;
    $goodMdp = false;
    $boolean_name = false;
    $boolean_mdp = false;
    $mdpIdentique = false;
    $noMdp = false;

    $um = new UserManager(connexionDb());
    $nameVerif = $um->getUserByUserName($userTest->getUserName());
    if ($nameVerif->getUserName() != NULL && $user->getUserName() != $UserName) {
        $nameExistant = true;
        $tab['ERROR']['Name'] = "Nom déjà existant ";
    }
    if (champsEmailValable($Email)) {
        $emailValable = true;
    } else {
        $tab['ERROR']['EmailValable'] = "Votre email contient des caractères indésirables";
    }
    if (champsEmailValable($UserName)) {
        $nameValable = true;
    } else {
        $tab['ERROR']['NameValable'] = "Votre nom d'utilisateur contient des caractères indésirables";
    }

    $mailVerif = $um->getUserByEmail($userTest->getEmail());
    if ($mailVerif->getUserName() != NULL && $user->getEmail() != $Email) {
        $mailExistant = true;
        $tab['ERROR']['Email'] = "Email déjà existant";
    }
    if ($user->getMdp() == hash("sha256", $MdpActuel)) {
        $goodMdp = true;

    } else {
        $tab['ERROR']['MdpActuel'] = "Mauvais mot de passe actuel ! Annulation de la modification";
    }
    if(isset($UserName) and strlen($UserName) >= $config['size_user_name'])
    {
        $boolean_name = true;
    }
    else
    {
        $tab['ERROR']['UserName'] = "Nom vide ou trop court (min: ". $config['size_user_name']. ")";
    }
    if  (isset($Mdp) and isset($MdpBis) and $Mdp == $MdpBis  and $Mdp != NULL ) {
        if (strlen($Mdp) >= $config['size_user_mdp']) {
            $boolean_mdp = true;
        } else {
            $tab['ERROR']['Mdp'] = "Mots de passe trop court (min: " . $config['size_user_mdp'] . ")";
        }
        if (champsMdpValable($Mdp)) {
            $mdpValable = true;
        } else {
            $tab['ERROR']['mdpValable'] = "Votre mot de passe contient des caractères indésirables";
        }
    } else {
        $noMdp = true;
    }

    if(isset($Mdp) and isset($MdpBis) and $Mdp != $MdpBis )
    {
        $tab['ERROR']['Mdp'] = "Le mot de passe et le mot de passe de vérification sont différents";
    }
    else
    {
        $mdpIdentique = true;
    }

    $tab['RETURN'] = ((($boolean_mdp && $mdpValable) || $noMdp) and $boolean_name and !$nameExistant and !$mailExistant and $goodMdp && $mdpIdentique && $nameValable && $emailValable);
    if ($tab['RETURN']) {
        if(isset($UserName) and $userTest->getUserName() != $user->getUserName())
        {
            $user->setUserName($UserName);
        }
        if(isset($Email) and $userTest->getEmail() != $user->getEmail())
        {
            $user->setEmail($Email);
        }
        if(isset($Mdp) and strlen($Mdp) > 4 and hash("sha256", $userTest->getMdp()) != $user->getMdp())
        {
            $user->setMdp($Mdp);
            $user->setHashMdp();
        }

        if(isset($tel) and $tel != $user->getTel()) {
            $user->setTel($tel);
        }

        $um->updateUserProfil($user);
        $userToReconnect = $um->getUserById($user->getId());
        setSessionUser($userToReconnect);

    }
    return $tab;
}