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
    require "../Library/Page/config.lib.php";
    require "../Library/Fonctions/Fonctions.php";

    if(!isConnect())header("Location:../");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <script type="text/javascript">
        function verification_inscription() {
            if (document.inscription.userName.value == "") {
                alert("Le login est obligatoire, rentrez-le !");
                document.inscription.userName.focus();
                return false;
            }
            if (document.inscription.email.value == "") {
                alert("L'email est obligatoire, rentrez-le !");
                document.inscription.email.focus();
                return false;
            }
            if (document.inscription.mdp.value == "") {
                alert("Le mdp est obligatoire, rentrez-le !");
                document.inscription.mdp.focus();
                return false;
            }
            if (document.inscription.emailConfirm.value != document.inscription.email.value) {
                alert("La vérification de l'email ne correspond pas, corrigez-le !");
                document.inscription.emailConfirm.focus();
                return false;
            }
            if (document.inscription.mdpConfirm.value != document.inscription.mdp.value) {
                alert("La vérification du mot de passe ne correspond pas, corrigez-le !");
                document.inscription.mdpConfirm.focus();
                return false;
            }
        }
    </script>
</head>
<?php
    echo "<p>Page Inscription</p>";
    $ini = getConfigFile();
    $um = new UserManager($db);
?>
<body>
    <form name="inscription" action="inscription.page.php" method="post" onSubmit="return verification_inscription()">
        <label for="userName">Login (6 caractères min) : </label><input type="text" id="userName" name="userName" <?php if (isset($_POST['userName'])) { echo "value='".htmlentities($_POST['login'])."'"; } ?>><br>
        <label for="mdp">Mot de passe (5 caractères min): </label><input type="text" id="mdp" name="mdp"><br>
        <label for="mdpConfirm">Confirmation mot de passe : </label><input type="text" id="mdpConf" name="mdpConf"><br>
        <label for="email">Email : </label><input type="text" id="email" name="email" <?php if (isset($_POST['email'])) { echo "value='".htmlentities($_POST['email'])."'"; } ?>><br>
        <label for="emailConfirm">Confirmation Email : </label><input type="text" id="emailConfirm" name="emailConfirm" <?php if (isset($_POST['emailConfirm'])) { echo "value='".htmlentities($_POST['emailConfirm'])."'"; } ?>><br>
        <button type="submit" id="formulaire" name="envoyer">Envoyer</button>
    </form>
    <?php
         if(isset($_POST['userName']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['mdpConfirm']) &&
            isset($_POST['emailConfirm']) && $_POST['mdp'] == $_POST['mdpConfirm'] && $_POST['email'] == $_POST['emailConfirm']) {
             $userName = strtolower($_POST['userName']);
             $mdp = $_POST['mdp'];
             $email = $_POST['email'];
             if (strlen($userName) < $ini['CONSTANTE']['size_user_name']) {
                 echo "Votre nom d'utilisateur est trop court, 6 caractères minimum ! <br>";
             } else if (strlen($mdp) < $ini['CONSTANTE']['size_user_mdp']) {
                 echo "Votre mot de passe est trop court, 5 caractères minimum ! <br>";
             } else {
                 $loginValable = 0;
                 $emailValable = 0;
                 $tbUser = getAllUser();
                while ($resultat = $tbUser->fetch()) {
                    if ($userName == $resultat->userName) {
                        $loginValable = 1;
                    }
                    if ($email == $resultat->email) {
                        $emailValable = 1;
                    }
                }
                 if ($loginValable == 1) {
                     echo "Ce login est déjà pris, veuillez en choisir en autre ! <br>";
                 }
                 else if ($emailValable == 1) {
                     echo "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                 }
                 else if (!champsEmailValable($email)) {
                     echo "Votre adresse mail contient des caractères indésirables !";
                 }
                 else if (!champsLoginValable($userName)) {
                     echo "Votre nom d'utilisateur contient des caractères indésirables !";
                 }
                 else if (!champsMdpValable($mdp)) {
                     echo "Votre mot de passe contient des caractères indésirables !";
                 }
                 else if ($loginValable == 0 && $emailValable == 0) {

                 }
             }


             $user = new User(array(
                 "UserName" => "Flavian",
                 "Mdp" => "Flavian",
             ));

             $user->setMdp(hash("sha256", $user->getMdp()));
             $um->addUser($user);
         }
    ?>
</body>
</html>