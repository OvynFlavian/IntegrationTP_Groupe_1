<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 18:01
 */
use \Entity\User as User;

function isValidForm()
{
    $config = getConfigFile()['CONSTANTE'];
    $UserName = isset($_POST['userName']) ? $_POST['userName'] : '';
    $Mdp = isset($_POST['Mdp']) ? $_POST['Mdp'] : '';
    $MdpBis = isset($_POST['MdpBis']) ? $_POST['MdpBis'] : '';

    $tab = array("RETURN" => false, "ERROR" => array());

    $boolean_name = false;
    $boolean_mdp = false;
    if(!empty($UserName) and strlen($UserName) >= $config['size_user_name'])
    {
        $boolean_name = true;
    }
    else
    {
        $tab['ERROR']['UserName'] = "Nom vide ou trop court (min: ". $config['size_user_name']. ")";
    }
    if(!empty($Mdp) and !empty($MdpBis) and $Mdp == $MdpBis)
    {
        if($Mdp > $config['size_user_mdp'])
        {
            $boolean_mdp = true;
        }
        else
        {
            $tab['ERROR']['Mdp'] = "Mots de passe trop court (min: ". $config['size_user_mdp']. ")";
        }
    }
    else if(!empty($Mdp) and !empty($MdpBis) and $Mdp != $MdpBis)
    {
        $tab['ERROR']['Mdp'] = "Mots de passe et le mots de passe de vérification sont différents";
    }
    else
    {
        $boolean_mdp = true;
    }

    $tab['RETURN'] = ($boolean_mdp and $boolean_name);
    return $tab;
}
function modifyProfil(User $user)
{
    $UserName = $_POST['userName'];
    $Mdp = $_POST['Mdp'];
    $Tel = $_POST['Tel'];
    $config = getConfigFile()['CONSTANTE'];

    $um = new UserManager(connexionDb());

    $userTest = new User(array(
        "UserName" => $UserName,
        "Mdp" => $Mdp,
        "tel" => $Tel,
    ));

    if(!empty($UserName) and $userTest->getUserName() != $user->getUserName() and $UserName > $config["size_user_name"])
    {
        $user->setUserName($UserName);
    }
    if(!empty($Mdp) and strlen($Mdp) > 4 and hash("sha256", $userTest->getMdp()) != $user->getMdp() and $config["size_user_mdp"])
    {
        $user->setMdp($Mdp);
        $user->setHashMdp();
    }

    if(!empty($Tel) and $Tel != $user->getTel())
        $user->setTel($Tel);

    $um->updateUserProfil($user);
    $userToReconnect = $um->getUserById($user->getId());
    setSessionUser($userToReconnect);
}