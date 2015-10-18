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
#TODO N'autoriser cette page que pour les inscrits et rediriger les autres
#TODO Un membre ne peut proposer une idée que toutes les semaines, penser à vérifier son délai (sauf si il est premium)
#TODO Si il est ok, penser à update sa date de dernière activité ajoutée
if (isPostFormulaire()) {
    ajouterActivite();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une activité :</title>
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
        include "../Form/ajouterActivite.form.php";
        ?>
    </section>
</section>
</body>
</html>