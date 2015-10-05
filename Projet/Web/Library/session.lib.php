<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:28
 */


function startSession()
{
    session_name("integration");
    session_start();
}

/**
 * Fonction permettant de savoir si un utilisateur est connecter
 * @return bool
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
    return (isConnect() ? $_SESSION['User'] : '');
}

function setSessionUser(User $user)
{
    $_SESSION['User'] = $user;
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