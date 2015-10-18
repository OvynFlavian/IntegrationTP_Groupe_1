<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 5/10/2015
 * Time: 09:37
 */

function hasErrorClass($errorFormulaire, $field)
{
    if(!empty($errorFormulaire))
    {
        if(!isset($errorFormulaire[$field]))
            echo 'has-success has-feedback';
        else
            echo 'has-error has-feedback';
    }

}
function viewProfil()
{
    $user = getSessionUser();?>
    <div class="form-group">
        <label class="control-label col-sm-2" for="userName">Pseudo:</label>
        <div class="col-sm-10">
            <p class="form-control-static"><?php echo $user->getUserName()?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="Tel">Téléphone:</label>
        <div class="col-sm-10">
            <p class="form-control-static"><?php echo $user->getTel()?></p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="Private" name="Private" value="true" <?php if($user->getIsPrivate()){?>checked<?php } ?> disabled>Visible ?
                </label>
            </div>
        </div>
    </div>
<?php
}
?>
<?php function editProfil($errorFormulaire)
{
    $user = getSessionUser();?>
<form class="form-horizontal" action="profil.page.php?to=edit" method="post">
    <div class="form-group <?php hasErrorClass($errorFormulaire, "UserName")?>">
        <label class="control-label col-sm-2" for="userName">Pseudo:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="userName" name="userName" value="<?php echo $user->getUserName()?>" placeholder="Votre pseudo">
            <?php
            if(!empty($errorFormulaire))
            {
                if(!isset($errorFormulaire['UserName'])){?><span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
            <span id="inputSuccess2Status" class="sr-only">(success)</span>
            <?php }
                else if(isset($errorFormulaire['UserName'])){?><span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            <span id="inputError2Status" class="sr-only">(error)</span>
            <?php } ?>
            <?php }?>
        </div>
    </div>
    <div class="form-group <?php hasErrorClass($errorFormulaire, "Mdp")?>">
        <label class="control-label col-sm-2" for="Mdp">Mot de passe:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="Mdp" name="Mdp" placeholder="Enter password">
            <?php
            if(!empty($errorFormulaire))
            {
                if(!isset($errorFormulaire['Mdp'])){?><span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                <?php }
                else if(isset($errorFormulaire['Mdp'])){?><span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                    <span id="inputError2Status" class="sr-only">(error)</span>
                <?php } ?>
            <?php }?>
        </div>
    </div>
    <div class="form-group <?php hasErrorClass($errorFormulaire, "MdpBis")?>">
        <label class="control-label col-sm-2" for="MdpBis">Mot de passe de confirmation</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="MdpBis" name="MdpBis" placeholder="Enter password">
            <?php
            if(!empty($errorFormulaire))
            {
                if(!isset($errorFormulaire['Mdp'])){?><span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                <?php }
                else if(isset($errorFormulaire['Mdp'])){?><span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                    <span id="inputError2Status" class="sr-only">(error)</span>
                <?php } ?>
            <?php }?>
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
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="Private" name="Private" value="1" <?php if($user->getIsPrivate() == 1){?>checked<?php }?>>Visible ?
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Soumettre</button>
        </div>
    </div>
</form>
<?php }?>