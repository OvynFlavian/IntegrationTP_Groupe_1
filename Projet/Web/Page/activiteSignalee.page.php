<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 8/11/2015
 * Time: 01:57
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
require "../Library/Page/activiteSignalee.lib.php";
require "../Manager/Categorie_ActivityManager.manager.php";
initRequireEntityManager();

startSession();
$isConnect = isConnect();
if(!$isConnect || ($_SESSION['User']->getDroit()[0]->getId() != 1 && $_SESSION['User']->getDroit()[0]->getId() != 2))
{

    header("Location:../");
}

$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des activités signalées</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

    <link rel="stylesheet" type="text/css" href="../personalisation.css">
</head>
<body>

<section class="container" id="administration">
    <header>
        <?php include("../Menu/menuGeneral.lib.php") ?>
    </header>
    <div class="col-md-2 clearfix" id="sub-menu-left">

    </div>
    <section class="col-lg-8 jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/signalement.png" alt="logo" /></h1>
        <p class="jumbotexte"> Affichage de la liste des activités signalées actuellement sur le site</p>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            afficherActivite();
            ?>
        </article>
    </section>
    <footer class="footer navbar-fixed-bottom">
        <div class="col-xs-4">&copy; everydayidea.be</div>
        <div class="col-xs-4" style="text-align: center"> Contactez <a href="mailto:postmaster@everydayidea.be">l'administrateur</a></div>
        <div class="col-xs-4"></div>
    </footer>
</section>
</body>
</html>