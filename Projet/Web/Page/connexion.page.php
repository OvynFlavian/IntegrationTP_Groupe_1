<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:34
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequirePage("connexion");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
$tabRetour = array();
if($isConnect)
{
    session_destroy();
    header("Location:../");
}
if(isPostFormulaire())
{
    $tabRetour = doConnect();
    if($tabRetour['Retour']&& $tabRetour['Valide'])header("Location:../");
}
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

    <script type="text/javascript">
        <?php
            include("../Script/connexion.js");
        ?>
    </script>
</head>
<body>
<header>
    <!--
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">EveryDayIdea</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="../">Home</a></li>
                    <li class="active"><a href="../Page/connexion.page.php">Connexion</a></li>
                    <li><a href="../Page/inscription.page.php">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>
    -->
    <?php include("../Menu/menuGeneral.lib.php") ?>
</header>
    <section class="container">
        <section class="jumbotron">
            <h1>Page de connexion</h1>
            <p>Entrez votre nom d'utilisateur et votre mot de passe !</p>
        </section>
        <section class="row">
            <article class="col-sm-12">
                <?php
                include("../Form/connexion.form.php");
                ?>
            </article>
        </section>
        <?php if(isset($tabRetour['Error'])){?>
            <section class="alert-dismissible">
                <p><?php echo $tabRetour['Error']?></p>
            </section>
        <?php }?>
        <?php if(isset($tabRetour['Activation'])){?>
            <section class="alert-dismissible">
                <p><?php echo $tabRetour['Activation']?></p>
            </section>
        <?php }?>
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