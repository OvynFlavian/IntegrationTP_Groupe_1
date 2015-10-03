<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 15:46
 */

?>

<form name="formulaire" action="inscription.page.php" method="post" onSubmit="return verification_inscription()">
    <label for="userName">Login (6 caractères min) : </label><input type="text" id="userName" name="userName" <?php if (isset($_POST['userName'])) { echo "value='".htmlentities($_POST['userName'])."'"; } ?>><br>
    <label for="mdp">Mot de passe (5 caractères min): </label><input type="password" id="mdp" name="mdp"><br>
    <label for="mdpConfirm">Confirmation mot de passe : </label><input type="password" id="mdpConf" name="mdpConf"><br>
    <label for="email">Email : </label><input type="email" id="email" name="email" <?php if (isset($_POST['email'])) { echo "value='".htmlentities($_POST['email'])."'"; } ?>><br>
    <label for="emailConfirm">Confirmation Email : </label><input type="email" id="emailConfirm" name="emailConfirm" <?php if (isset($_POST['emailConfirm'])) { echo "value='".htmlentities($_POST['emailConfirm'])."'"; } ?>><br>
    <button type="submit" id="formulaire" name="envoyer">Envoyer</button>
</form>