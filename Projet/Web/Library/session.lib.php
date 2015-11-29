<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:28
 */
use \Entity\User as User;

/**
 * Fonction faisant débuter la session.
 */
function startSession()
{
    session_name("integration");
    session_start();
}

/**
 * Fonction permettant de savoir si un utilisateur est connecter
 * @return bool : true si il est connecté, false sinon.
 */
function isConnect()
{
    return (isset($_SESSION['User']));
}

/**
 * Fonction permettant de récupérer la variable session lié à un utilisateur
 * @return string
 */
function getSessionUser()
{
    return (isConnect() ? $_SESSION['User'] : new User(array()));
}

/**
 * Fonction permettant de générer la session de l'utilisateur.
 * @param User $user : l'utilisateur concerné.
 */
function setSessionUser(User $user)
{
    $_SESSION['User'] = $user;
}

/**
 * Fonction vérifiant le password de l'admin.
 * @return bool : true si le password est bon, sinon false.
 */
function checkAdminPwd()
{
    $userSession = getSessionUser();
    $userMdpTest = new User(array(
        "Mdp" => $_POST['mdpAdmin'],
    ));
    $userMdpTest->setHashMdp();

    if($userSession->getDroit()[0]->getLibelle() and $userSession->getMdp() == $userMdpTest->getMdp())return true;
    return false;
}

/*function isAllow()
{
    $user = getSessionUser();
    if(!empty($user))
        $right = $user->getDroit()[0];
        return byRight($right->getLabelle());
}

function byRight($right)
{
    switch ($right)
    {
        case "Admin":
        case "Premium":
        case "User":
            return true;
            break;
        default:
            return TRUE;
    }
}*/