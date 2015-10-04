<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:35
 */
    require "../Library/database.lib.php";
    require "../Entity/User.class.php";
    require "../Manager/UserManager.manager.php";
    require "../Library/config.lib.php";
    require "../Library/Fonctions/Fonctions.php";
    require "../Library/post.lib.php";
    require "../Library/session.lib.php";
    require "../Manager/ActivationManager.manager.php";
    require "../Entity/Activation.class.php";

    require "../Library/Page/inscription.lib.php";
    connexionDb();
    if(isConnect())header("Location:../");
    if(isPostFormulaire() && isValidBis()['Retour'])
        addDB();


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <script type="text/javascript">
        <?php
            include("../Script/inscription.js");
        ?>
    </script>
</head>
<body>
    <?php
        echo "<p>Page Inscription</p>";
        include("../Form/inscription.form.php");
    ?>

</body>
</html>