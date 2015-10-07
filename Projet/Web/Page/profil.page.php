<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 16:48
 */

require "../Library/constante.lib.php";
/*require "../Library/session.lib.php";
require "../Library/post.lib.php";
require ".". PATH_ENTITY. "User". PATH_END_ENTITY;

require "../Library/database.lib.php";
require "../Library/Page/profil.lib.php";
require "../Manager/UserManager.manager.php";
require "../Library/config.lib.php";*/
initRequire();
initRequirePage("profil");
//require "../Library/Page/profil.lib.php";
require "../Entity/User.class.php";
require "../Entity/Droit.class.php";
require "../Manager/UserManager.manager.php";

startSession();
if(!isConnect())header("Location:index.php");
if(isPostFormulaire())
{
    if(isValidForm()['RETURN'])
    {
        modifyProfil();
    }
    else
    {
        $errorFormulaire = isValidForm()['ERROR'];
    }
    unset($_POST['formulaire']);
}

$um = new UserManager(connexionDb());

//TODO remplacer l'id 1 par getSessionUser()->getId()
$user = $um->getUserById(getSessionUser()->getId());

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
    <?php include("../Form/profil.form.php");?>
    <!--<script>
        var jsTab = <?php echo '["'. implode('", "', isset($errorFormulaire)? $errorFormulaire : array()). '"]'?>;
        if(jsTab.length > 0)
        {
            alert(jsTab.join("\n"));
        }
    </script>-->
</body>
</html>