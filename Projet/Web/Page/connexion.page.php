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
    if($tabRetour['Retour']&& $tabRetour['Valide'] && $tabRetour['Banni'])header("Location:../");
}
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
        <?php include("../Menu/menuGeneral.lib.php") ?>
    </header>
    <div class="col-md-2 clearfix" id="sub-menu-left">

    </div>
    <section class="col-lg-8 jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/connexion.png" alt="logo" id='image-media'></h1>
        <p class="jumbotexte">Entrez votre nom d'utilisateur et votre mot de passe !</p>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php include("../Form/connexion.form.php"); ?>
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
    <footer class="footer navbar-fixed-bottom">
        <div class="col-xs-4">&copy; everydayidea.be</div>
        <div class="col-xs-4" style="text-align: center"> Contactez <a href="mailto:postmaster@everydayidea.be">l'administrateur</a></div>
        <div class="col-xs-4"></div>
    </footer>
</section>
</body>
</html>