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
