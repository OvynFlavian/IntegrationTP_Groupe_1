<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 8/11/2015
 * Time: 18:44
 */

    echo "<form method='post' action='administration.page.php'>";
    echo "<input type='hidden'  name='idUserMess'  value='$id'>";
    echo "<h1> Envoi de message à l'utilisateur $name</h1><br><br>";
?>
<div class="form-group col-sm-12">
    <label class="control-label col-sm-2" for="activite">Titre:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="titre" name="titre" placeholder="Votre titre">
    </div>
</div>
<div class="form-group col-sm-12">
    <label class="control-label col-sm-2" for="description">Message :</label>
    <div class="col-sm-10">
        <textarea class="form-control" rows="5" id="description" name="description" placeholder="Texte du message" required></textarea>
    </div>
</div>
<div class="form-group col-sm-12">
    <div class="col-sm-offset-2 col-sm-12">
        <button type="submit" class="btn btn-default" name="formulaireEnvoi" id="formulaireEnvoi">Envoyer</button>
    </div>
</div>
</form>