<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 16:48
 */

require "../Library/constante.lib.php";
require "../Library/session.lib.php";
require "../Library/post.lib.php";
require ".". PATH_ENTITY. "User". PATH_END_ENTITY;

require "../Library/database.lib.php";
require "../Library/Page/profil.lib.php";
require "../Manager/UserManager.manager.php";

session_start();
if(isPostFormulaire() and isValidForm())modifyProfil();
$um = new UserManager(connexionDb());
$user = $um->getUserById(1);

$_SESSION['User'] = $user;
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
<form action="profil.page.php" method="post">
    <label for="UserName">Login : </label>
    <input type="text" id="UserName" name="UserName" value="<?php echo $user->getUserName() ?>">
    <br>
    <label for="Mdp">Password : </label>
    <input type="password" id="Mdp" name="Mdp" value="">
    <label for="MdpBis">Password verify: </label>
    <input type="password" id="MdpBis" name="MdpBis" value="">
    <br>
    <label for="Tel">Telephone : </label>
    <input type="text" id="Tel" name="Tel" value="<?php echo $user->getTel() ?>">
    <br>
    <button type="submit" id="formualire" name="formulaire">Modifier</button><button type="reset">Reset</button>
</form>
</body>
</html>