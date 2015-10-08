<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 16:48
 */

require "../Library/constante.lib.php";
initRequire();
initRequirePage("profil");

require "../Entity/User.class.php";
require "../Entity/Droit.class.php";
require "../Manager/UserManager.manager.php";

startSession();
$isConnect = isConnect();
if(!$isConnect)header("Location:../index.php");

$um = new UserManager(connexionDb());
$user = $um->getUserById(getSessionUser()->getId());

if(isPostFormulaire())
{
    if(isValidForm()['RETURN'])
    {
        modifyProfil($user);
    }
    else
    {
        $errorFormulaire = isValidForm()['ERROR'];
    }
    unset($_POST['formulaire']);
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="../Style/presentationCss.css">
</head>
<body>
    <header>
        <?php
            if(!$isConnect)include("..". MENU_ANONYME_PAGE);
            else include("..". MENU_CONNECTER_PAGE);
        ?>
    </header>
    <section id="section_corps">
        <div id="div_left">
            &nbsp;
        </div>
        <div id="div_center">
            <h1>Page de gestion de profil</h1>
            <?php include("../Form/profil.form.php");?>
        </div>
        <div id="div_right">
            &nbsp;
        </div>
    </section>

    <script>
        var jsTab = <?php echo '["'. implode('", "', isset($errorFormulaire)? $errorFormulaire : array()). '"]'?>;
        if(jsTab.length > 1)
        {
            alert(jsTab.join("\n"));
        }
    </script>
</body>
</html>