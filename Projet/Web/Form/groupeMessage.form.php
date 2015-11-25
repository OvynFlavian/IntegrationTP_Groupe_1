<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 18:55
 */

?>

<form class="form-inline" name='message' action='groupe.page.php?to=voirGroupe' method='post'>
    <div class="form-group">
        <label for="description">Votre message : </label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Votre message" style="width:65em">
    </div>
    <button type="submit" class="btn btn-default" name="poster">Envoyer</button>
</form>