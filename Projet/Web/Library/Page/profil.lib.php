<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 18:01
 */

function isValidForm()
{
    $config = getConfigFile()['CONSTANTE'];
    $UserName = $_POST['UserName'];
    $Mdp = $_POST['Mdp'];
    $MdpBis = $_POST['MdpBis'];
    $Tel = $_POST['Tel'];
    $tab = array("RETURN" => false, "ERROR" => array());

    $boolean_name = true;
    $boolean_mdp = true;
    $boolean_tel = true;
    if(empty($UserName) or $UserName <= $config['size_user_name'])
    {
        $boolean_name = false;
        $tab['ERROR'][] = "Nom vide ou trop court (min: ". $config['size_user_name']. ")";
    }
    if(empty($Mdp) or empty($MdpBis) or $Mdp <= $config['size_user_mdp'])
    {
        $boolean_mdp = false;
        $tab['ERROR'][] = "Mots de passe vide ou trop court (min: ". $config['size_user_mdp']. ")";
    }
    else if($Mdp != $MdpBis)
    {
        $boolean_mdp = false;
        $tab['ERROR'][] = "Mots de passe et le mots de passe de vérification sont différents";
    }
    if(empty($Tel))
    {
        $boolean_tel = false;
        $tab['ERROR'][] = "Numéro de téléphone vide";
    }
    $tab['RETURN'] = $boolean_mdp or $boolean_name or $boolean_tel;
    return $tab;
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
    if(!empty($UserName) and $userTest->getUserName() != $user->getUserName())
    {
        $user->setUserName($UserName);
    }
    if(strlen($Mdp) > 4 and hash("sha256", $userTest->getMdp()) != $user->getMdp())
    {
        $user->setMdp($Mdp);
    }

    if(!empty($Tel) and $Tel != $user->getTel())
        $user->setTel($Tel);
    var_dump($user);
    $user->setHashMdp();

    $um->updateUserProfil($user);
}

function echoError($tabError)
{
    $sizeTab = sizeof($tabError);
    $errorStr = '';
    for($i = 0; $i < $sizeTab; $i++)
    {
        if($i < $sizeTab-1)$errorStr .= $tabError[$i]. "\n";
        else $errorStr .= $tabError[$i];
    }
    echo '<script>
            var jsTab = <?php ?>
            alert("'. $tabError. '".join("\n"))</script>';
}