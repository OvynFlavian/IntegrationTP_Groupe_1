<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 15:46
 */

?>

<form class="form-horizontal" action="inscription.page.php" method="post" onSubmit='return verification_inscription()'>
    <div class="form-group">
        <label class="control-label col-sm-2" for="userName">Pseudo:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre pseudo">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="mdp">Mot de passe:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrer votre password">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="mdpConfirm">Mot de passe de confirmation:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="mdpConfirm" name="mdpConfirm" placeholder="Encore une fois">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="email">Mail:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="email" placeholder="Votre adresse mail">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="emailConfirm">Mail de confirmation:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="emailConfirm" name="emailConfirm" placeholder="Encore une fois">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Envoyer</button>
        </div>
    </div>
</form>