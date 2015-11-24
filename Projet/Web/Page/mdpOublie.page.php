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
</head>
<body>
    <header>
        <?php
            include("../Menu/menuGeneral.lib.php");
        ?>
    </header>
    <section class="container">
        <section class="jumbotron">
            <h1>Récuperer son mot de passe</h1>
            <p>Entrez votre l'adresse e-mail de votre compte afin de recevoir un message de récupération !</p>
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
                formulaireChangement();
                changementMdp();
            }
            ?>
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