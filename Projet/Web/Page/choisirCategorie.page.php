<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequirePage("choisirCategorie");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une catégorie</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Choisir une catégorie</h1>
        <p>Choisissez une catégorie pour votre activité du jour :</p>
    </section>
    <section class="row">
        <article class="col-sm-6">
            <a href="proposerActivite.page.php?categorie=visite" title="Visite"><img src="../Images/visite.png" alt="visite"/></a>
        </article>
        <article class="col-sm-6">
            <a href="proposerActivite.page.php?categorie=film" title="film"><img src="../Images/film.jpg" alt="film"/></a>
        </article>
    </section>
</section>
</body>
</html>