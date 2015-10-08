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
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposer une activité</title>
</head>
<body>
<h1>Voici l'activité qui vous est proposée par EveryDayIdea :</h1>
<?php
    if (isset($_GET['categorie'])) {
        $cat = $_GET['categorie'];
        gererReponse($cat);
        proposerActivite($cat);
    } else {
        echo "Vous n'avez pas de catégorie !";
    }

?>

</body>
</html>