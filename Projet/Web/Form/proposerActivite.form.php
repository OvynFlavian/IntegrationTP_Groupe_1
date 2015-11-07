<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 21:00
 */


echo "<form class='form-horizontal col-sm-12' name='activite' action='proposerActivite.page.php?categorie=$cat&activite=$id' method='post'>";
?>
    <?php
    if (!isConnect()) {
      echo  " <button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='Inscription'>Vous n'êtes pas inscrit ? Inscrivez vous !</button>";
    } else {
        echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='Accepter'>Ok !</button>";
    }
    ?>

    <button class="btn btn-warning col-sm-6" type='submit' id='formulaire' name='Refuser'>Une autre !</button>
</form>