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
var_dump($_SERVER['REQUEST_URI']);
//require "../Library/Page/profil.lib.php";
require "../Entity/User.class.php";
require "../Manager/UserManager.manager.php";

startSession();
if(isPostFormulaire() and isValidForm()['RETURN'])modifyProfil();
$um = new UserManager(connexionDb());

//TODO remplacer l'id 9 par getSessionUser()->getId()
$user = $um->getUserById(9);
$errorFormulaire = isValidForm()['ERROR'];

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
    <?php include("../Form/profil.form.php");?>
    <script>
        var jsTab = <?php echo '["'. implode('", "', $errorFormulaire). '"]'?>;
        if(jsTab.length > 0)
        {
            alert(jsTab.join("\n"));
        }
    </script>
</body>
</html>