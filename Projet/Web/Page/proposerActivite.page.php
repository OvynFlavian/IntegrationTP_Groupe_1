<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:30
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequirePage("proposerActivite");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposer une activité</title>
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
        <h1>Page des activités</h1>
        <p>Voici l'activité qui vous est proposée par EveryDayIdea :</p>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            if (isset($_GET['categorie'])) {
                $cat = $_GET['categorie'];
                gererReponse($cat);
                proposerActivite($cat);
            } else {
                echo "Vous n'avez pas de catégorie !";
            }

            ?>
        </article>
    </section>
</section>
</body>
</html>