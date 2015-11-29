<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 19:29
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequireEntityManager();
require "../Library/Page/devenirPremium.lib.php";
require "../Manager/User_DroitManager.manager.php";

$configIni = getConfigFile();
startSession();
connexionDb();
$isConnect = isConnect();
if(!isConnect() or $_SESSION['User']->getDroit()[0]->getLibelle() == 'Premium' or $_SESSION['User']->getDroit()[0]->getLibelle() == 'Administrateur' or $_SESSION['User']->getDroit()[0]->getLibelle() == 'Moderateur')header("Location:../");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devenir membre Premium</title>
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

    <section class="jumbotron">
        <h1>Devenir Premium</h1>
        <p>

            <?php
            Premium();
            echo "Vous êtes bien devenu membre premium !";
            header("Location:profil.page.php");
            ?>

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