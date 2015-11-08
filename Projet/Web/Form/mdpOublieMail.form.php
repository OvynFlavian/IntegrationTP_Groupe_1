<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:09
 */
?>

<form class="form-horizontal" name='emailMdp' action='mdpOublie.page.php' method='post' onSubmit='return verification_emailMdp()'>
    <div class="form-group col-sm-12">
        <label class="col-sm-2" for="email">Email:</label>
        <div class="col-sm-10">
            <input class="form-control" id="email" name='email' type='email' placeholder="Votre email" required>
        </div>

    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Envoyer</button>
        </div>
    </div>

</form>