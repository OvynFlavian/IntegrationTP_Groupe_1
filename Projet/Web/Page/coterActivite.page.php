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
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Coter une activité</h1>
        <p>Cela fait plus de six heures que vous avez la même activité ! Que diriez-vous de la coter ?</p>

    </section>
    <section class="row" >
        <?php
            include "../Form/coterActivite.form.php";
            gererFormulaire();
        ?>
    </section>
</section>
<div class="footer-container">
    <div class="row">
        <footer class="footer panel-footer navbar-fixed-bottom">
            &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo 'postmaster@everydayidea.be'?>">l'administrateur</a></span>
        </footer>
    </div>
</div>
</body>
</html>