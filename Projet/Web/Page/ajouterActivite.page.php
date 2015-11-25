<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 18/10/2015
 * Time: 17:17
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";
initRequire();
initRequirePage("ajouterActivite");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
if(!$isConnect )header("Location:../");
$userSession = getSessionUser();
if (isPostFormulaire()) {
    $tabRetour = ajouterActivite();
}
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une activité </title>
    <link rel="icon" type="image/png" href="../Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
    <script type="text/javascript">
        <?php
            include "../Script/ajouterActivite.js";
        ?>
    </script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Ajouter une activité</h1>
        <p>Choisissez une catégorie et écrivez l'activité que vous voulez ajouter :</p>

    </section>
    <section class="row">
        <?php
        if(($userSession->getDroit()[0]->getId() == 3 || $userSession->getDroit()[0]->getId() == 2 || $userSession->getDroit()[0]->getId() == 1) || ($userSession->getDroit()[0]->getId() == 4 && dateLastIdea())) {
            include "../Form/ajouterActivite.form.php";
        } else {
            echo "<h1 align='center'><div class='alert alert-danger' role='alert'>Vous avez déjà posté une activité cette semaine, devenez Premium pour pouvoir en proposer autant que vous en voulez !</div></h1>";
        }
        ?>
        </section>
        <section class="alert-dismissible">
        <?php
        if (isset($tabRetour['Error'])) {
            echo "<div class='alert alert-danger' role='alert'>".$tabRetour['Error']."</div>";
        } else if (isset($tabRetour['Ok'])) {
            echo "<div class='alert alert-success' role='alert'>".$tabRetour['Ok']."</div>";
            echo "<meta http-equiv='refresh' content='2; URL=../'>";
        }
        ?>
        </section>

</section>
<div class="footer-container">
    <div class="row">
        <footer class="footer panel-footer navbar-fixed-bottom">
            &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo 'postmaster@everydayidea.be'?>">l'administrateur</a></span>
        </footer>
    </div>
</div>
</body>
</html>