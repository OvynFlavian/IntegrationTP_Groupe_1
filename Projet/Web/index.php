<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 13:58
 */

require "./Library/constante.lib.php";
require "./Library/session.lib.php";
require "./Entity/User.class.php";
startSession();

$isConnect = isConnect();
$configIni = parse_ini_file("config.ini", true);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./Style/presentationCss.css">
</head>
<body>
<header>
    <?php
        if(!$isConnect)include(".". MENU_ANONYME);
        else include(".". MENU_CONNECTER);
    ?>
</header>
<section id="section_corps">
    <div id="div_left">
        &nbsp;
    </div>
    <div id="div_center">
        <h1>Page d'accueil</h1>
        <?php
        if(!isConnect())
            echo "<p style='text-align: center'>Il n'y a pas de user de connecté</p>";
        else
            echo "<p style='text-align: center'>Le user connecté est : </p><table>". getSessionUser()->toStringList(). "</table>" ?>
    </div>
    <div id="div_right">
        &nbsp;
    </div>
</section>
<footer>
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>

</body>
</html>