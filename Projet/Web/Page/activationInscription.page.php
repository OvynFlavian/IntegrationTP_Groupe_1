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
initRequirePage("activationInscription");
initRequireEntityManager();

startSession();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activation</title>
</head>
<body>
<?php
echo "<p>Page d'activation</p>";
if (!isset($_GET['code'])){
    echo "Vous avez besoin d'un code d'activation pour vous activer !";
} else {
    activationNewUser();
}
?>

</body>
</html>