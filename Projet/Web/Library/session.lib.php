<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:28
 */

function isConnect()
{
    return (isset($_SESSION['User']));
}

function getSessionUser()
{
    return (isConnect() ? $_SESSION['User'] : '');
}

function postSessionForm()
{
    return isset($_SESSION['modif']);
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