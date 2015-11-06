<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 19:27
 */
?>

<form class="form-horizontal" action="listeMembres.page.php" method="post">
    <div class="form-group">
        <label class="control-label col-sm-2" for="userName">Nom d'utilisateur :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Le pseudo recherché">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Rechercher</button>

        </div>
    </div>
</form>
