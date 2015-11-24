<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 23/11/2015
 * Time: 23:15
 */
$id = $_GET['membre'];
echo "<form class='form-horizontal col-sm-12' name='activite' action='groupe.page.php?to=ajouter&membre=$id' method='post'>";
?>
<h1 align="center"> Êtes-vous sûr de vouloir ajouter ce membre à votre groupe ?</h1><br><br>
<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='Accepter'>Oui, je suis sûr !</button>
<button class="btn btn-warning col-sm-6" type='submit' id='formulaire' name='Refuser'>Je me suis trompé !</button>
</form>