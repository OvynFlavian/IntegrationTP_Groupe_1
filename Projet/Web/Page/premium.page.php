<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 25/11/2015
 * Time: 22:56
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequireEntityManager();
initRequirePage("inscription");

$configIni = getConfigFile();
startSession();
connexionDb();
$isConnect = isConnect();
if(!$isConnect or $_SESSION['User']->getDroit()[0]->getLibelle() == 'Premium' or $_SESSION['User']->getDroit()[0]->getLibelle() == 'Administrateur' or $_SESSION['User']->getDroit()[0]->getLibelle() == 'Moderateur')header("Location:../");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devenir Premium</title>
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

<section class="container" id="administration">
    <section class="jumbotron">
        <h1>Comment devenir Premium ?</h1>
        <p>Vous pouvez lire ci-dessous les différentes étapes à mettre en oeuvre afin de devenir premium sur EveryDayIdea !</p>
    </section>

<section class="row">
    <article class="col-sm-12">
        <h1 align="center"> Les différentes étapes pour devenir membre Premium :</h1>
        <ol>
            <li>Tout d'abord vous devez posséder un compte Paypal. Si vous n'en possédez pas un, <b><a href="https://www.paypal.com/be/signup/account?locale.x=fr_BE" target="_blank">créez-en un en cliquant ici</a></b></li>
            <li> Le coût du compte Premium est de <b>2,50€</b>, pensez à <b>avoir cette somme</b> sur votre compte Paypal avant de lancer le payement </li>
            <li> Cliquez ensuite sur le bouton <b>"Faire un don"</b> disponible en bas de la page</li>
            <li> Ce bouton vous emmenera sur une nouvelle page du site Paypal qui vous demandera de vous connecter. <b>Connectez-vous</b> pour lancer la suite du payement</li>
            <li> Paypal vérifiera ensuite si vos informations personnelles sont bonnes. Sur cette page, vous verrez en haut un champ <b>"Entrez votre nom d'utilisateur"</b></li>
            <li> Cliquez sur ce champ et <b>encodez votre nom d'utilisateur</b>, il sera affiché sur votre payement auprès de l'admnistrateur. Cela servira au cas-où la finalisation se passe mal </li>
            <li> <b>Lancer le payement</b></li>
            <li> Vous allez arriver sur une page marquant que le payement a bien été effectué, cette page <b>contient un bouton permettant de revenir sur EveryDayIdea</b></li>
            <li> <b>Cliquez sur ce bouton impérativement ! Ce n'est qu'en revenant sur le site que vous deviendrez premium !</b></li>
            <?php
                buttonPaypal();
            ?>
        </ol>
    </article>
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