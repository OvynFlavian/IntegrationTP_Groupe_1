<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:34
 */
require "../Library/constante.lib.php";

initRequire();
initRequirePage("connexion");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
if($isConnect)
{
    session_destroy();
    header("Location:../");
}
if(isPostFormulaire())
{
    doConnect();
    header("Location:../");
}
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../Style/presentationCss.css">
    <script type="text/javascript">
        <?php
            include("../Script/connexion.js");
        ?>
    </script>
</head>
<body>
    <header>
        <?php
            if(!$isConnect)include("..". MENU_ANONYME_PAGE);
            else include("..". MENU_CONNECTER_PAGE);
        ?>
    </header>
    <section id="section_corps">
        <div id="div_left">&nbsp;</div>
        <div id="div_center">
            <h1>Page Connexion</h1>
            <?php
                include("../Form/connexion.form.php");
            ?>
            <a href="./mdpOublie.page.php"> Mot de passe oublié ? </a> <br> <br> <br>
        </div>
        <div id="div_right">&nbsp;</div>
    </section>
    <footer>
        &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
    </footer>
</body>
</html>