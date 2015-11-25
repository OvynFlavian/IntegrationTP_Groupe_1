<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 17:51
 */
$id = $_GET['groupe'];
echo "<form class='form-horizontal col-sm-12' name='rejoindre' action='groupe.page.php?to=rejoindre&groupe=$id' method='post'>";
?>
<h1 align="center"> Êtes-vous sûr de vouloir rejoindre ce groupe ?</h1><br><br>
<h1 align="center"> Toutes les invitations qui vous ont été envoyées seront supprimées</h1><br><br>
<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='AccepterRejoindre'>Oui, je suis sûr !</button>
<button class="btn btn-warning col-sm-6" type='submit' id='formulaire' name='RefuserRejoindre'>Je me suis trompé !</button>
</form>