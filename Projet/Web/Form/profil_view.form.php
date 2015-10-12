<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 12/10/2015
 * Time: 17:13
 */
?>

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