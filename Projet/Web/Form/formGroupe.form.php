<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 20:22
 */
use \Entity\Groupe as Groupe;

function formGroupe(Groupe $groupe)
{
    echo "<div class='formGroupe'>";
    echo "<form class='form-horizontal col-sm-12' name='formGroupe' action='groupe.page.php?to=voirGroupe&action=mod' method='post'>";
    echo "<input type='hidden'  name='idGroupe'  value='" . $groupe->getIdGroupe() . "''>";
    if ($groupe->getIdLeader() == $_SESSION['User']->getId()) {
        echo "<button class='btn btn-warning col-sm-2' type='submit' id='modif' name='modifier'>Modifier votre groupe</button>";
        echo "<button class='btn btn-danger col-sm-2' type='submit' id='delete' name='delete'>Supprimer votre groupe</button>";
    } else {
        echo "<button class='btn btn-danger col-sm-2' type='submit' id='leave' name='leave'>Quitter le groupe</button>";
    }
    echo "</form>";
    echo "</div>";
}