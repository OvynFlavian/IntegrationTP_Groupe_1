<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 15:46
 */

?>

<form name="inscription" action="inscription.form.php" method="post">
    <label for="userName">Login : </label><input type="text" id="userName" name="userName"><br>
    <label for="mdp">Mot de passe : </label><input type="text" id="mdp" name="mdp"><br>
    <label for="mdpConfirm">Confirmation mot de passe : </label><input type="text" id="mdpConf" name="mdpConf"><br>
    <label for="email">Email : </label><input type="text" id="email" name="email"><br>
    <label for="emailConfirm">Confirmation Email : </label><input type="text" id="emailConfirm" name="emailConfirm"><br>
    <button type="submit" id="formulaire" name="formulaire">Envoyer</button>
</form>