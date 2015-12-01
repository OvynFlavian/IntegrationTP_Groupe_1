<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 13:58
 */

require "./Library/constante.lib.php";
require "./Library/get.lib.php";
require "./Library/session.lib.php";
require "./Entity/User.class.php";
require "./Entity/Droit.class.php";
require "Manager/ActivityManager.manager.php";
require "Manager/User_ActivityManager.manager.php";
require "Entity/Activity.class.php";
require "Library/database.lib.php";
require "Library/config.lib.php";
require "Library/Fonctions/Fonctions.php";
require "Manager/UserManager.manager.php";
require "Manager/DroitManager.manager.php";

startSession();

$isConnect = isConnect();
$configIni = getConfigFile();
if (isConnect()) {
    $um = new UserManager(connexionDb());
    $user = $um->getUserById($_SESSION['User']->getId());
    $_SESSION['User'] = $user;

}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="icon" type="image/png" href="Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="./vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./Style/general.css">

    <link rel="stylesheet" type="text/css" href="./personalisation.css">
</head>
<body>

<section class="container" id="administration">
    <header>
        <?php include("./Menu/menuGeneral.lib.php"); ?>
    </header>
    <div class="col-md-2 clearfix" id="sub-menu-left">

    </div>
        <section class="col-lg-8 jumbotron">

            <h1> <img class="jumbotitre" src="Images/bannieres/accueil.png" alt="logo" id='image-media'></h1>
            <p class="jumbotexte">

                <?php if($isConnect){ ?>
                    Bienvenu(e) <?php echo getSessionUser()->getUserName() ?> sur le site de EveryDayIdea
                <?php }else{?>
                    Bienvenu(e) sur le site de EveryDayIdea
                <?php }?>

            </p>

        </section>
    <div class="col-lg-12">
        <section class="row">
            <article class="col-lg-12 col-sm-12">
                <?php
                echo "<div class='media'>";
                echo "<div class='media-right media-middle' >";

                echo "<img class='media-object' src='Images/accueil/ampoule.png' alt='EveryDayIdea' >";

                echo "</div>";
                echo "<div class='media-body media-right'>";
                echo "<h3  class='media-heading'>Activité du jour </h3>";
                if (!isConnect()) {
                    echo "Pour bénéficier de cette fonctionnalité, vous devez <a href='Page/connexion.page.php'><b>être connecté !</b></a>";
                } else {
                    $uam = new User_ActivityManager(connexionDb());
                    $tab = $uam->getActIdByUserId($_SESSION['User']);
                    $am = new ActivityManager(connexionDb());

                    if (!isset($tab[0]['id_activity'])) {
                        echo "Vous n'avez pas encore choisi d'activité aujourd'hui ! <a href='Page/choisirCategorie.page.php'><b>Choississez-en une</b></a> !";
                    } else {
                        $act = $am->getActivityById($tab[0]['id_activity']);
                        echo "<p><Votre activité choisie du jour est :</p>";
                        echo "<div class='activityIndex'>";
                        echo "<img class='photoAct' src='Images/activite/".$tab[0]['id_activity'].".jpg' alt='photoActivite' />";
                        echo "<p><h3>".$act->getLibelle()."</h3></p>";
                        echo "<p> Sa description est : <h4>".$act->getDescription()."</h4></p>";
                        echo "</div>";
                        echo "<div id='info'>";
                        echo "<p> Il est toujours possible de la changer via <b><a href='Page/choisirCategorie.page.php'>le choix d'activités</a></b> !</p>";
                        echo "<p><b> Bon amusement !</b></p>";
                        echo "</div>";
                    }

                }
                echo "</div>";
                echo "</div>";


                ?>

            </article>
            <article class="col-sm-12">
                <?php
                if (!isConnect()) {
                    echo "<div class='media'>";
                    echo "<div class='media-left media-middle' >";

                    echo "<img  class='media-object' src='Images/accueil/interrogation.png' alt='EveryDayIdea'>";

                    echo "</div>";
                    echo "<div class='media-body'>";
                    echo "<h3  class='media-heading'>Qu'est-ce que EveryDayIdea ?</h3>";
                    echo "<p>Vous vous ennuyez et vous ne savez absolument pas quoi faire ? <b>Nous avons la solution</b> pour vous !</p>";
                    echo "<p>EveryDayIdea vous permet de <a href='Page/choisirCategorie.page.php'><b>trouver une activité selon une catégorie choisie !</b></a></p>";
                    echo "<p>Si elle vous plait, acceptez-la, sinon vous pouvez continuer à fouiller jusqu'à trouver celle qui vous plait !</p>";
                    echo "<p>Si vous avez envie de participer à la vie du site, <a href='Page/inscription.page.php'><b>inscrivez-vous !</b></a></p>";
                    echo "<p>Vous pourrez ainsi proposer vos propres idées et permettre à d'autres personnes d'y participer !</p>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<div class='media'>";
                    echo "<div class='media-left media-middle' >";

                    echo "<img class='media-object' src='Images/accueil/exclamation.png' alt='EveryDayIdea'>";

                    echo "</div>";
                    echo "<div class='media-body'>";
                    echo "<h3  class='media-heading'>Bienvenue sur EveryDayIdea ! </h3>";
                    echo "<p>Vous vous ennuyez et vous ne savez absolument pas quoi faire ? <b>Nous avons la solution</b> pour vous !</p>";
                    echo "<p>EveryDayIdea vous permet de <a href='Page/choisirCategorie.page.php'><b>trouver une activité selon une catégorie choisie !</b></a></p>";
                    echo "<p>Si elle vous plait, acceptez-la, sinon vous pouvez continuer à fouiller jusqu'à trouver celle qui vous plait !</p>";
                    echo "<p> Maintenant que vous êtes connecté, vous avez droit à des tonnes de fonctionnalités supplémentaires !";
                    echo "<p> Dorénavant, vous pouvez <a href='Page/listeMembres.page.php'><b> Chercher des amis !</b></a> ou bien <a href='Page/amis.page.php'><b>Gérer vos amis et vos demandes d'amis !</b> </a></p>";
                    echo "<p> N'hésitez pas non plus à <a href='Page/ajouterActivite.page.php'><b>ajouter une activité </b></a> si le coeur vous en dit !</p>";
                    echo "<p> Mais si vous voulez ajouter plus d'une activité par semaine ou pouvoir vous grouper avec d'autres personnes pour faire une activité :";
                    echo "<p align='center'><b>Devenez Premium grâce à notre bouton Don dans la barre de navigation ! </b></p>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </article>

        </section>
    </div>

    <footer class="footer navbar-fixed-bottom">
        <div class="col-xs-4">&copy; everydayidea.be</div>
        <div class="col-xs-4" style="text-align: center"> Contactez <a href="mailto:postmaster@everydayidea.be">l'administrateur</a></div>
        <div class="col-xs-4"></div>
    </footer>
</section>





</body>
</html>