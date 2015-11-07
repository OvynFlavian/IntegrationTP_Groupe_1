<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 5/11/2015
 * Time: 21:28
 */

echo "<form class='form-horizontal' action='proposerActivite.page.php?categorie=$cat&choix=personnel' method='post'>";
?>
    <div class="form-group">
        <label class="control-label col-sm-2" for="userName">Activité recherchée :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="activite" name="activite" placeholder="L'activité recherchée">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Rechercher</button>

        </div>
    </div>
</form>