<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:35
 */
    require "../Library/database.lib.php";
    $db = connexionDb();
    require "../Entity/User.class.php";
    require "../Manager/UserManager.manager.php";

    if(!isConnect())header("Location:../");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <?php
        echo "<p>Page Inscription</p>";

        $um = new UserManager($db);
        $user = new User(array(
            "UserName" => "Flavian",
            "Mdp" => "Flavian",
        ));

        $user->setMdp(hash("sha256", $user->getMdp()));
        $um->addUser($user);
    ?>
</body>
</html>