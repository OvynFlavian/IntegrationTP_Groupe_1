<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 18:01
 */

function isValidForm()
{
    require "../Library/config.lib.php";
    $config = getConfigFile()['CONSTANTE'];
    $UserName = $_POST['UserName'];
    $Mdp = $_POST['Mdp'];
    $Tel = $_POST['Tel'];

    return true;
}
function modifyProfil()
{
    $userSession = getSessionUser();
    $user = getType($userSession) == "object" ? $userSession : new User(array());

    $UserName = $_POST['UserName'];
    $Mdp = $_POST['Mdp'];
    $Tel = $_POST['Tel'];

    $um = new UserManager(connexionDb());

    $userTest = new User(array(
        "UserName" => $UserName,
        "Mdp" => $Mdp,
        "Tel" => $Tel,
    ));
    if($userTest->getUserName() != $user->getUserName())
        $user->setUserName($UserName);
    if($userTest->getMdp() != "" and hash("sha256", $userTest->getMdp()) != $user->getMdp())
        $user->setMdp($Mdp);
    if($Tel != $user->getTel())
        $user->setTel($Tel);

    $um->updateUserProfil($user);
}