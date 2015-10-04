<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 22:07
 */
?>
<form name="formulaire" action="connexion.page.php" method="post" onSubmit="return verification_connexion()">

    Login : 				<input name="userName" type="text"> <br>
    Mot de passe :				<input name="mdp" type="password"> <br>
    <input type="submit" name="envoyer">

</form>