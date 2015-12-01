<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequireEntityManager();
initRequirePage("inscription");
require "../Library/Page/activationInscription.lib.php";

$configIni = getConfigFile();
startSession();
connexionDb();
$isConnect = isConnect();
if($isConnect)header("Location:../");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activation de votre inscription</title>
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

    </div>
    <section class="col-lg-8 jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/activation.png" alt="logo" /></h1>
        <p class="jumbotexte">
            <?php if(!isset($_GET['code'])){?>
                Vous avez besoin d'un code d'activation pour vous activer !
            <?php }else{activationNewUser();}?>
        </p>
    </section>
    <footer class="footer navbar-fixed-bottom">
        <div class="col-xs-4">&copy; everydayidea.be</div>
        <div class="col-xs-4" style="text-align: center"> Contactez <a href="mailto:postmaster@everydayidea.be">l'administrateur</a></div>
        <div class="col-xs-4"></div>
    </footer>
</section>

</body>
</html>