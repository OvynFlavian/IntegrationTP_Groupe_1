<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:34
 */
require "../Library/database.lib.php";
require "../Entity/User.class.php";
require "../Manager/UserManager.manager.php";
require "../Library/config.lib.php";
require "../Library/Fonctions/Fonctions.php";
require "../Library/post.lib.php";
require "../Library/session.lib.php";


require "../Library/Page/connexion.lib.php";

session_start();
var_dump($_SESSION);
if(isPostFormulaire()) {
    doConnect();

}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <script type="text/javascript">
        <?php
            include("../Script/connexion.js");
        ?>
    </script>
</head>
<body>
    <?php
        echo "<p>Page Connexion</p>";
        include("../Form/connexion.form.php");
    ?>
    <a href="index.php?page=mdpOublie"> Mot de passe oublié ? </a> <br> <br> <br>

</body>
</html>