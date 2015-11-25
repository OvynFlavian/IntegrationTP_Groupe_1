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
if (isConnect()) {
    $uam = new User_ActivityManager(connexionDb());
    $tab = $uam->getActIdByUserId($_SESSION['User']);
    if (isset($tab[0]['id_activity']) && comparerHeure($tab[0]['date'], 6)) {
        header("Location:coterActivite.page.php");

    }
}
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
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Choisir une catégorie</h1>
        <p>Choisissez une catégorie pour votre activité du jour :</p>

    </section>
    <section class="row" id="proposerCat">
        <?php
        afficherCategorie();
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