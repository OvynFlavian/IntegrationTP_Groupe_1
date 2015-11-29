<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";
require "../Manager/User_ActivityManager.manager.php";
initRequire();
initRequirePage("choisirCategorie");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une catégorie</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

    <link rel="stylesheet" type="text/css" href="../personalisation.css">
</head>
<body>
<section class="container" style="padding-bottom : 55%;">
    <header>
        <?php include("../Menu/menuGeneral.lib.php"); ?>
    </header>
    <?php
    if (isConnect()) {
        $uam = new User_ActivityManager(connexionDb());
        $tab = $uam->getActIdByUserId($_SESSION['User']);
        if (isset($tab[0]['id_activity']) && comparerHeure($tab[0]['date'], 6)) {?>
            <div class="col-md-2 clearfix" id="sub-menu-left">
                <nav class="sidebar-nav">
                    <ul class="nav sidebar-nav sidebar-collapse">
                        <li <?php if(empty($_GET)) {echo 'class="active"';}?>><a href="choisirCategorie.page.php">Choisir une catégorie</a></li>
                        <li><a href="coterActivite.page.php">Coter mon ancienne activité</a></li>
                    </ul>
                </nav>
            </div>
        <?php }else{ ?>
            <div class="col-md-2 clearfix" id="sub-menu-left">

            </div>
        <?php }
    }?>
    <section class="col-lg-8 jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/categorie.png" alt="logo" /></h1>
        <p class="jumbotexte">Choisissez une catégorie pour votre activité du jour :</p>

    </section>
    <section class="row col-lg-12" id="proposerCat">
        <?php
        afficherCategorie();
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