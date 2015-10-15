<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 13:58
 */

require "./Library/constante.lib.php";
require "./Library/session.lib.php";
require "./Entity/User.class.php";
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
</head>
<body>
<header>
    <?php include("./Menu/menuGeneral.lib.php"); ?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Accueil Page</h1>
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
            <h3>Activité du jours</h3>
            <?php foreach($configIni['SERVEUR_ADDRESS'] as $key => $value){ ?>
                <p><?php echo $key. "->". $value; ?></p>
            <?php }?>
        </article>
        <article class="col-sm-6">
            <h3>Activité de groupe du jours</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
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
<footer class="panel-footer ">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>

</body>
</html>