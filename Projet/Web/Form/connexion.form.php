<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 22:07
 */
?>
<form name="formulaire" action="connexion.page.php" method="post" onSubmit="return verification_connexion()">

    <label for="userName">Login : </label><input id="userName" name="userName" type="text"> <br>
    <label for="mdp">Mot de passe :	</label><input id="mdp" name="mdp" type="password"> <br>
    <input type="submit" name="envoyer">

</form>