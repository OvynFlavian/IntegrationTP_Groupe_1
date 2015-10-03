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
        function verification_inscription() {
            if (document.formulaire.userName.value == "") {
                alert("Le login est obligatoire, rentrez-le !");
                document.formulaire.userName.focus();
                return false;
            }
            if (document.formulaire.email.value == "") {
                alert("L'email est obligatoire, rentrez-le !");
                document.formulaire.email.focus();
                return false;
            }
            if (document.formulaire.mdp.value == "") {
                alert("Le mdp est obligatoire, rentrez-le !");
                document.formulaire.mdp.focus();
                return false;
            }
            if (document.formulaire.emailConfirm.value != document.formulaire.email.value) {
                alert("La vérification de l'email ne correspond pas, corrigez-le !");
                document.formulaire.emailConfirm.focus();
                return false;
            }
            if (document.formulaire.mdpConfirm.value != document.formulaire.mdp.value) {
                alert("La vérification du mot de passe ne correspond pas, corrigez-le !");
                document.formulaire.mdpConfirm.focus();
                return false;
            }
        }
    </script>
</head>
<?php
    echo "<p>Page Inscription</p>";
?>
<body>
    <form name="formulaire" action="inscription.page.php" method="post" onSubmit="return verification_inscription()">
        <label for="userName">Login (6 caractères min) : </label><input type="text" id="userName" name="userName" <?php if (isset($_POST['userName'])) { echo "value='".htmlentities($_POST['userName'])."'"; } ?>><br>
        <label for="mdp">Mot de passe (5 caractères min): </label><input type="password" id="mdp" name="mdp"><br>
        <label for="mdpConfirm">Confirmation mot de passe : </label><input type="password" id="mdpConf" name="mdpConf"><br>
        <label for="email">Email : </label><input type="email" id="email" name="email" <?php if (isset($_POST['email'])) { echo "value='".htmlentities($_POST['email'])."'"; } ?>><br>
        <label for="emailConfirm">Confirmation Email : </label><input type="email" id="emailConfirm" name="emailConfirm" <?php if (isset($_POST['emailConfirm'])) { echo "value='".htmlentities($_POST['emailConfirm'])."'"; } ?>><br>
        <button type="submit" id="formulaire" name="envoyer">Envoyer</button>
    </form>

</body>
</html>