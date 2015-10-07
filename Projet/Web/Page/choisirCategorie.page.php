<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/database.lib.php";
require "../Entity/Categorie.class.php";
require "../Manager/CategorieManager.manager.php";
require "../Library/config.lib.php";
require "../Library/Fonctions/Fonctions.php";
require "../Library/post.lib.php";
require "../Library/session.lib.php";


require "../Library/Page/choisirCategorie.lib.php";

startSession();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une catégorie</title>
</head>
<body>
<h1>Choisissez une catégorie pour votre activité du jour :</h1>
<a href="proposerActivite.page.php?categorie=visite" title="Visite"><img src="../Images/visite.png" alt="visite"/></a>
<a href="proposerActivite.page.php?categorie=film" title="film"><img src="../Images/film.jpg" alt="film"/></a>

</body>
</html>