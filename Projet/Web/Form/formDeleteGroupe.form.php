<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 20:34
 */
?>
<form class='form-horizontal col-sm-12' name='delete' action='groupe.page.php?to=voirGroupe&action=mod' method='post'>

<h1 align="center"> Êtes-vous sûr de vouloir supprimer ce groupe ?</h1><br><br>
<h1 align="center"> Les membres et invitations ainsi que les messages liées à votre groupe seront supprimés</h1><br><br>
<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='AccepterSupprimer'>Oui, je suis sûr !</button>
<button class="btn btn-warning col-sm-6" type='submit' id='formulaire' name='Refuser'>Je me suis trompé !</button>
</form>