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


startSession();


$isConnect = isConnect();
$configIni = parse_ini_file("config.ini", true);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="./vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./Style/general.css">
</head>
<body>
<header>
    <?php include("./Menu/menuGeneral.lib.php"); ?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page d'accueil</h1>
        <p>
            <?php if($isConnect){ ?>
                Bienvenu(e) <?php echo getSessionUser()->getUserName() ?> sur le site de EveryDayIdea
            <?php }else{?>
                Bienvenu(e) sur le site de EveryDayIdea
            <?php }?>
        </p>
    </section>
    <section class="row">
        <article class="col-sm-6">
            <h3>Activité du jour</h3>
                <p><?php echo "Nous n'avons pas encore configuré cette option, ce sera pour bientôt !";?></p>

        </article>
        <article class="col-sm-6">
            <h3>Qu'est-ce que EveryDayIdea ?</h3>
            <p>Vous vous ennuyez et vous ne savez absolument pas quoi faire ? <b>Nous avons la solution</b> pour vous !</p>
            <p>EveryDayIdea vous permet de <a href="Page/choisirCategorie.page.php"><b>trouver une activité selon une catégorie choisie !</b></a></p>
            <p>Si elle vous plait, acceptez-la, sinon vous pouvez continuer à fouiller jusqu'à trouver celle qui vous plait !</p>
            <p>Si vous avez envie de participer à la vie du site, <a href="Page/inscription.page.php"><b>inscrivez-vous !</b></a></p>
            <p>Vous pourrez ainsi proposer vos propres idées et permettre à d'autres personnes d'y participer !</p>
        </article>
    </section>
    <?php if(isConnect()){?>
    <section class="row">
        <article class="col-sm-6">
            <h3>L'utilisateur connecté</h3>
            <table>
                <tr><th>Pseudo</th><th>Dernière connexion</th></tr>
                <tr>
                    <?php foreach(getSessionUser()->toStringArray() as $key => $value){?>
                        <td>
                            <?php
                                if($key == "Derniere_connexion")
                                    echo $value->format("H:i => d/m/Y");
                                else echo $value
                            ?>
                        </td>
                    <?php }?>
                </tr>
            </table>


        </article>
    </section>
    <?php }?>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>

</body>
</html>