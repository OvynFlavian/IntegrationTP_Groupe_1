<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:35
 */
    require "../Library/constante.lib.php";
    initRequire();
    initRequirePage("inscription");
    initRequireEntityManager();

    $configIni = getConfigFile();
    startSession();
    connexionDb();
    $isConnect = isConnect();
    if($isConnect)header("Location:../");
    if(isPostFormulaire() && isValidBis()['Retour']) {

        addDB();
    } else if (isPostFormulaire() and !isValidBis()['Retour']) {

        foreach (isValidBis()['Error'] as $elem) {
            echo $elem;
        }
    }
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <script type="text/javascript">
        <?php
            include("../Script/inscription.js");
        ?>
    </script>
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
                    <li><a href="../">Home</a></li>
                    <li><a href="../Page/connexion.page.php">Connexion</a></li>
                    <li class="active"><a href="../Page/inscription.page.php">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page d'inscription</h1>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            include("../Form/inscription.form.php");
            ?>
        </article>
    </section>
    <?php if(isset($tabRetour['Error'])){?>
        <section class="alert-dismissible">
            <p><?php echo $tabRetour['Error']?></p>
        </section>
    <?php }?>
</section>
<footer class="panel-footer">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
</html>