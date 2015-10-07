<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 13:58
 */

require "./Library/constante.lib.php";
require "./Library/session.lib.php";
require "./Entity/User.class.php";
startSession();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
<header>
    <a href="Page/connexion.page.php">Connexion</a> |
    <a href="Page/inscription.page.php">Inscription</a>
    <a href="Page/profil.page.php">Profil</a>
</header>
<?php
    if(!isConnect())
        echo "<p>Il n\'y a pas de user de connecté</p>";
    else
        echo "<p>Le user de connecter est : ". getSessionUser()->getUserName(). "</p>" ?>

</body>
</html>