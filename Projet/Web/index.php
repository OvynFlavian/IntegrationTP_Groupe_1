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
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">EveryDayIdea</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="./">Home</a></li>
                    <?php if(!$isConnect){?>
                        <li><a href="./Page/connexion.page.php">Connexion</a></li>
                        <li><a href="./Page/inscription.page.php">Inscription</a></li>
                    <?php }else{ ?>
                        <li><a href="./Page/connexion.page.php">Déconnexion</a></li>
                        <li><a href="./Page/profil.page.php">Profil</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>
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
</section>
<footer class="panel-footer">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>

</body>
</html>