<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 5/10/2015
 * Time: 09:37
 */
?>

<form class="form-horizontal" action="connexion.page.php" method="post">
    <div class="form-group">
        <label class="control-label col-sm-2" for="userName">Pseudo:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="userName" name="userName" value="<?php echo $user->getUserName()?>" placeholder="Votre pseudo">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="Mdp">Mot de passe:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="Mdp" name="Mdp" placeholder="Enter password">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="MdpBis">Mot de passe de confirmation</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="MdpBis" name="MdpBis" placeholder="Enter password">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="Tel">Téléphone:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="Tel" name="Tel" value="<?php echo $user->getTel() ?>" placeholder="Enter password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Soumettre</button>
        </div>
    </div>
</form>