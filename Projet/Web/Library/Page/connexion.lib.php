<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 22:53
 */
function doConnect()
{
    $mdp = $_POST['mdp'];
    $userName = $_POST['userName'];
    $manager = new UserManager(connexionDb());
    $tabUser = $manager->getAllUser();
    $userToConnect = new User(array(
        "UserName" => $userName,
        "Mdp" => $mdp
    ));

    /**
     * Je vérifie sur le user est dans la base de donnée et existe bel et bien
     */
    $echec = false;
    foreach ($tabUser as $elem) {

        //$mdp == hash("sha256", $elem->getMdp());
        //password_verify($mdp, $elem->getMdp())
        if ($userName == $elem->getUserName() && hash("sha256", $userToConnect->getMdp()) == $elem->getMdp()) {
            $echec = false;
            $id = $elem->getId();
            $email = $elem->getEmail();
            break;
        } else {
            $echec = true;

        }

    }

    /**
     * Je vérifie que le user n'a pas besoin de s'activer avant de se connecter, l'user pouvant avoir
     * deux code (inscription et mdp oublié), je vérifie que c'est bien le code d'inscription
     */
    $needActi = false;
    if (isset($id) && !empty($id)) {
        require "../Manager/ActivationManager.manager.php";
        require "../Entity/Activation.class.php";
        $acManager = new ActivationManager(connexionDb());
        $act = $acManager->getActivationByLibelleAndId("Inscription",$id);
        if (isset($act) && !empty($act->getCode())) {
            $needActi = true;
        }
        else {
            $needActi = false;
        }
    }

    if ($echec == true) {
        echo "Erreur lors de la connexion, veuillez rééssayer avec le bon login ou mot de passe !";
    }
    else if ($needActi == true) {
        echo "Vous devez activer votre compte avant la connexion !";
    } else {
        $user = new User(array(
            "UserName" => $userName,
            "Mdp" => $mdp,
            "id" => $id,
            "email" => $email,

        ));

        $manager->updateUserConnect($user);
        $_SESSION['User'] = $user;
        echo "Bienvenue sur EveryDayIdea !";

    }
}