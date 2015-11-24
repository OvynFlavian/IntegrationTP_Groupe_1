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
require "../Manager/User_ActivityManager.manager.php";
require "../Manager/User_GroupeManager.manager.php";
require "../Entity/Groupe.class.php";
require "../Manager/GroupeManager.manager.php";

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
            <li <?php if((empty($_GET))) {echo 'class="active"';}?>><a href="groupe.page.php">Voir les utilisateurs</a></li>
            <?php
                if (!hasGroupe()) {
                    echo "<li";
                    if(isset($_GET['to']) && $_GET['to'] == 'creerGroupe') {
                        echo ' class="active"';
                    }
                    echo "><a href='groupe.page.php?to=creerGroupe'>Créer votre groupe</a></li>";
                } else {
                    echo "<li";
                    if(isset($_GET['to']) && $_GET['to'] == 'voirGroupe') {
                        echo ' class="active"';
                    }
                    echo "><a href='groupe.page.php?to=voirGroupe'>Voir mon groupe</a></li>";
                }
            ?>
        </ul>
    </aside>
</header>
<section class="container" id="administration">
    <section class="jumbotron">
        <h1>Page d'affichage du groupe</h1>
        <?php
            if (!isset($_GET['to'])) {
                echo "<p>Affichage de la liste des membres premium possédant la même activité que vous. Il est possible de les ajouter à votre groupe ou de rejoindre leur groupe !</p>";
            } else if (isset($_GET['to']) && $_GET['to'] == 'creerGroupe') {
                echo "<p>Créez votre groupe ! Vous pourrez ensuite inviter d'autres membres dedans pour leur partager votre activité ensemble !</p>";
            }



        ?>
    </section>
    <section class="alert-dismissible">

    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            if (!hasActivity()) {
                echo "<h1><div class='alert alert-warning' role='alert'> Vous n'avez pas d'activité pour le moment ! <a href='choisirCategorie.page.php'>Choississez une activité !</a></div></h1>";
            } else {
                if (!isset($_GET['to'])) {
                    afficherMembres();
                }  else if (isset($_GET['to']) && $_GET['to'] == 'creerGroupe') {
                    if (hasGroupe()) {
                        header("Location:../");
                    } else {
                        creerGroupe();
                        formCreerGroupe();
                    }

                }
            }
            ?>
        </article>
    </section>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a></span>
</footer>

</body>