<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 5/10/2015
 * Time: 09:37
 */
use \Entity\User as User;

function editProfil() {
    $user = getSessionUser();
?>

<form class="form-horizontal" action="profil.page.php?to=edit" method="post">
    <div class="form-group">
        <label class="control-label col-sm-3" for="userName">Changement de pseudo:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="userName" name="userName" value="<?php echo $user->getUserName()?>" placeholder="Votre pseudo">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="userName">Changement d'adresse mail:</label>
        <div class="col-sm-6">
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->getEmail()?>" placeholder="Votre email">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="Mdp">Changement de mot de passe:</label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="Mdp" name="Mdp" placeholder="Entrez votre mot de passe">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="MdpBis">Réentrez votre changement de mot de passe :</label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="MdpBis" name="MdpBis" placeholder="Réentrez votre mot de passe">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="Tel">Changer de numéro de téléphone:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="Tel" name="Tel" value="<?php echo $user->getTel() ?>" placeholder="Entrez votre numéro de téléphone">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            <div class="checkbox">
                <label>
                    <input  type="checkbox" id="Private" name="Private" value="1" <?php if($user->getIsPrivate() == 1){?>checked<?php }?>>S'afficher en public
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-3" for="MdpActuel">Entrez votre mot de passe actuel : (obligatoire pour le changement) </label>
        <div class="col-sm-6">
            <input type="password" class="form-control" id="MdpActuel" name="MdpActuel" placeholder="Entrez votre mot de passe actuel" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn-block btn-primary btn-lg" name="formulaire" id="formulaire">Soumettre</button>
        </div>
    </div>
</form>
<?php } ?>