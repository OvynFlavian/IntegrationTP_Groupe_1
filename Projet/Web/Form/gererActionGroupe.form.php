<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 28/11/2015
 * Time: 20:37
 */

function formGererActionGroupe($action, $id) {
echo "<form class='form-horizontal col-sm-12' name='action' action='groupe.page.php?to=voirGroupe' method='post'>";
if ($action == 'supprimer') {
    $do = 'supprimer';
} else if ($action == 'lead') {
    $do = 'nommer chef de groupe';
}
echo "<h1 align='center'> Êtes-vous sûr de vouloir $do ce membre ?</h1><br><br>";

echo "<button class='btn btn-success col-sm-6' type='submit' id='formulaire' name='Accepter$action'>Oui, je suis sûr !</button>";
echo "<button class='btn btn-warning col-sm-6' type='submit' id='formulaire' name='Refuser$action'>Je me suis trompé !</button>";
 echo "<input type='hidden'  name='membre'  value='" . $id . "''>";


echo "</form>";

    }
   ?>