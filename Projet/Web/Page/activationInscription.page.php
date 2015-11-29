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
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
</header>

<section class="container">
    <section class="jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/activation.png" alt="logo" /></h1>
        <p class="jumbotexte">
            <?php if(!isset($_GET['code'])){?>
                Vous avez besoin d'un code d'activation pour vous activer !
            <?php }else{activationNewUser();}?>
        </p>
    </section>
</section>
<div class="footer-container">
    <div class="row">
        <footer class="footer panel-footer navbar-fixed-bottom">
            &copy; everydayidea.be <span class="marge"> Contactez <a href="mailto:<?php echo 'postmaster@everydayidea.be'?>">l'administrateur</a></span>
        </footer>
    </div>
</div>
</body>
</html>