<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 22:53
 */
use \Entity\User as User;

/**
 * Fonction vérifiant l'identité du membre et le connectant si il possède la bonne identité.
 * @return array : tableau de message d'erreur dans le cas où ses informations sont fausses, si il est banni ou encore
 * si il ne s'est pas activé.
 */
function doConnect()
{
    $tabRetour = array();

    $mdp = $_POST['mdp'];
    $userName = $_POST['userName'];

    $manager = new UserManager(connexionDb());
    $tabUser = $manager->getAllUser();

    $userToConnect = new User(array(
        "UserName" => $userName,
        "Mdp" => $mdp
    ));
    $userFound = $manager->getUserByUserName($userName);
    /**
     * Je vérifie sur le user est dans la base de donnée et existe bel et bien
     */
    $echec = false;
    if ($userFound->getId() != NULL) {
        foreach ($tabUser as $elem) {

            //$mdp == hash("sha256", $elem->getMdp());
            //password_verify($mdp, $elem->getMdp())

            if ($userName == $elem->getUserName() && hash("sha256", $userToConnect->getMdp().$userFound->getSalt()) == $elem->getMdp()) {
                $echec = false;
                $userToConnect = $elem;
                $id = $elem->getId();
                break;
            } else {
                $echec = true;
            }

        }
    } else {
        $echec = true;
    }

    /**
     * Je vérifie que le user n'a pas besoin de s'activer avant de se connecter, l'user pouvant avoir
     * deux code (inscription et mdp oublié), je vérifie que c'est bien le code d'inscription
     */
    $needActi = false;
    $banni = false;
    if (isset($id)) {
        $acManager = new ActivationManager(connexionDb());
        $act = $acManager->getActivationByLibelleAndId("Inscription",$id);
        if (isset($act) && $act->getCode() != NULL)
            $needActi = true;
        else
            $needActi = false;
    }
    $userToConnect = $manager->getUserById($userToConnect->getId());
    if ($echec == true) {
        $tabRetour['Error'] = "<div class='alert alert-danger' role='alert'>Erreur lors de la connexion, veuillez rééssayer avec le bon login ou mot de passe !</div>";
    } else if ($userToConnect->getDroit()[0]->getId() == 6) {
        $tabRetour['Error'] = "<div class='alert alert-danger' role='alert'>Vous êtes banni, impossible de vous connecter !</div>";
        $banni = true;
    }
    else if ($needActi == true)
        $tabRetour['Activation'] = "<div class='alert alert-danger' role='alert'>Vous devez activer votre compte avant la connexion !</div>";
    else  {
        $user = $manager->getUserById($id);
        $manager->updateUserConnect($user);
        //$_SESSION['User'] = $user;
        setSessionUser($user);
        echo "Bienvenue sur EveryDayIdea !";

    }
    $tabRetour['Retour'] = !$echec;
    $tabRetour['Valide'] = !$needActi;
    $tabRetour['Banni'] = !$banni;
    return $tabRetour;
}