<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 19:25
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
require "../Library/Page/listeMembres.lib.php";
initRequireEntityManager();

startSession();
$isConnect = isConnect();
if(!$isConnect)
{
    session_destroy();
    header("Location:../");
}
$tab = array();
$tab = rechercheMembre();
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des membres</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php") ?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Liste des membres</h1>
        <p> Affichage de la liste des membres présents actuellement sur le site.</p>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            include("../Form/listeMembres.form.php");
            ?>
        </article>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            afficherMembres($tab);
            ?>
        </article>
    </section>
</section>
<div class="footer-container">
    <div class="row">
        <footer class="footer panel-footer navbar-fixed-bottom">
            &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a></span>
        </footer>
    </div>
</div>
</body>
</html>