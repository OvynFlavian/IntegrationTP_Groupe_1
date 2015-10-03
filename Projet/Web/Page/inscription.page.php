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

    if(isConnect())header("Location:../");
    if(isPostFormulaire() && isValid())
    {
        /** @var $um : un nouvel user qui va être ajouté à la BDD
         J'ajoute le nouvel user à la BDD*/
        $um = new UserManager(connexionDb());
        $um->addUser(new User(array(
            "UserName" => $_POST['UserName'],
            "Mdp" => $_POST['Mdp'],

        )));
        /**
         * Ici j'ai besoin de savoir quel est le user id du nouveau membre ajouté pour pouvoir le mettre dans l'ajout du code d'activation de cet user
         * Donc je vais le rechercher en base de donnée où il vient d'être ajouté
         */
        $user = $um->getUserByUserName($_POST['userName']);
        $userid = $user->getId();
        /**
         * J'ajoute le nouveau code d'activation à la BDD
         */
        $ac = new ActivationManager(connexionDb());
        $ac->addActivation(new Activation(array(
            "code" => $code_aleatoire,
            "id_user" => $userid,
            "libelle" => "Inscription",
        )));
    }
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