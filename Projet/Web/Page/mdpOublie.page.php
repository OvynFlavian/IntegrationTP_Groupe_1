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
initRequirePage("mdpOublie");
initRequireEntityManager();

startSession();

if(isConnect())header("Location:../");
$configIni = getConfigFile();
$isConnect = isConnect();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <link rel="icon" type="image/png" href="../Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
    <script type="text/javascript">
        <?php
            include("../Script/mdpOublie.js");
        ?>
    </script>

    <link rel="stylesheet" type="text/css" href="../personalisation.css">
</head>
<body>
    <section class="container">
        <header>
            <?php include("../Menu/menuGeneral.lib.php"); ?>
        </header>
        <div class="col-md-2 clearfix" id="sub-menu-left">

        </div>
        <section class="col-lg-8 jumbotron">
            <h1> <img class="jumbotitre" src="../Images/bannieres/mdpoublie.png" alt="logo" id='image-media'></h1>
            <p class="jumbotexte">Entrez votre l'adresse e-mail de votre compte afin de recevoir un message de récupération </p>
        </section>
        <section class="alert-dismissible">

        </section>
        <section class="row">
            <?php
            if (!isset($_GET['code']))
            {
                formulaireMail();
                envoiCode();
            }
            else
            {
                changementMdp();
                formulaireChangement();

            }
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