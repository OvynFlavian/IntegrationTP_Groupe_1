<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 23:08
 */

echo "<form class='form-horizontal col-sm-12' name='activite' action='demandeAmi.page.php?membre=$id' method='post'>";
?>
<h1 align="center"> Êtes-vous sûr de vouloir ajouter ce membre comme ami ?</h1><br><br>
<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='Accepter'>Oui, je suis sûr !</button>
<button class="btn btn-warning col-sm-6" type='submit' id='formulaire' name='Refuser'>Je me suis trompé !</button>
</form>