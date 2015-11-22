<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 20:41
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";
initRequire();
initRequireEntityManager();
require "../Library/Page/groupe.lib.php";

$configIni = getConfigFile();
startSession();
$user = getSessionUser();
$isConnect = isConnect();
if(!$isConnect or ($_SESSION['User']->getDroit()[0]->getLibelle() != 'Premium' and $_SESSION['User']->getDroit()[0]->getLibelle() != 'Administrateur' and $_SESSION['User']->getDroit()[0]->getLibelle() != 'Moderateur'))header("Location:../");


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Groupe d'activité</title>
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
    <aside class="col-md-2" style="max-width: 250px;">
        <ul class="nav nav-pills nav-stacked" >
            <li <?php if((empty($_GET) || (isset($_GET['to']) && $_GET['to'] == 'profil'))) {echo 'class="active"';}?>><a href="administration.page.php">Voir les utilisateurs</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "viewConfig"){echo 'class="active"';}?>><a href="?to=viewConfig">Voir la configuration</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "editConfig"){echo 'class="active"';}?>><a href="?to=editConfig">Éditer la configuration</a></li>
        </ul>
    </aside>
</header>
<section class="container" id="administration">
    <section class="jumbotron">
        <h1>Page d'affichage du groupe</h1>
        <?php
        if (!isset($_GET['to'])) {
            echo "<p>Affichage de la liste des membres premium possédant la même activité que vous. Il est possible de les ajouter à votre groupe ou de rejoindre leur groupe !</p>";
        } else if (isset($_GET['to'])) {
            if ($_GET['to'] == 'viewConfig') {
                echo "<p>Affichage de la configuration de votre site.</p>";
            } else if ($_GET['to'] == 'editConfig') {
                echo "<p>Vous pouvez modifier la configuration de base de votre site.</p>";
            }
        }

        ?>
    </section>
    <section class="alert-dismissible">

    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php

            ?>
        </article>
    </section>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a></span>
</footer>

</body>