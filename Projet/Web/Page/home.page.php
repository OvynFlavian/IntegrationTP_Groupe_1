<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 13:58
 */
    require_once "../Library/constante.lib.php";
    require_once "../Library/session.lib.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <header>
        <a href="./connexion.page.php">Connexion</a> |
        <a href="./inscription.page.php">Inscription</a>
    </header>
    <?php if(!isConnect())echo "<p>Il n\'y a pas de user de connecté</p>"?>

</body>
</html>