<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 23:41
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";
initRequire();
initRequirePage("choisirCategorie");
initRequireEntityManager();
require "../Library/Page/coterActivite.lib.php";
require "../Manager/User_ActivityManager.manager.php";

startSession();
$isConnect = isConnect();
$configIni = getConfigFile();

if (!isConnect()) {
    header("Location:../");
}


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Coter une activité</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

    <link rel="stylesheet" type="text/css" href="../personalisation.css">
</head>
<body>
<section class="container">
    <header>
        <?php include("../Menu/menuGeneral.lib.php");?>
    </header>
    <div class="col-md-2 clearfix" id="sub-menu-left">
        <nav class="sidebar-nav">
            <ul class="nav sidebar-nav sidebar-collapse">
                <li><a href="choisirCategorie.page.php">Choisir une catégorie</a></li>
                <li <?php if(empty($_GET)) {echo 'class="active"';}?>><a href="coterActivite.page.php">Coter mon ancienne activité</a></li>
            </ul>
        </nav>
    </div>

    <section class="col-lg-8 jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/coteractivite.png" alt="logo" /></h1>
        <p class="jumbotexte">Cela fait plus de six heures que vous avez la même activité ! Que diriez-vous de la coter ?</p>

    </section>
    <section class="row col-lg-12">
        <?php
            include "../Form/coterActivite.form.php";
            gererFormulaire();
        ?>
    </section>
    <footer class="footer navbar-fixed-bottom">
        <div class="col-xs-4">&copy; everydayidea.be</div>
        <div class="col-xs-4" style="text-align: center"> Contactez <a href="mailto:postmaster@everydayidea.be">l'administrateur</a></div>
        <div class="col-xs-4"></div>
    </footer>
</section>
</body>
</html>