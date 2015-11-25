<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 23:42
 */

function gererFormulaire() {
    $uam = new User_ActivityManager(connexionDb());
    $tab = $uam->getActIdByUserId($_SESSION['User']);
    $am = new ActivityManager(connexionDb());
    if (isset($tab[0]) && $tab[0]['id_activity'] != null && comparerHeure($tab[0]['date'], 6)) {
        $act = $am->getActivityById($tab[0]['id_activity']);
        if (isset($_POST['Accepter'])) {
            if (isset($_POST['cote']) && $_POST['cote'] != NULL) {
                $cote = $_POST['cote'];
                $note = $act->getNote();
                $votants = $act->getVotants();
                $note = (($note * $votants) + $cote) / ($votants + 1);
                $votants = $votants + 1;
                $am->updateCote($act->getId(), $note, $votants);
                $uam->deleteFromTable($_SESSION['User']);
                header("Location:choisirCategorie.page.php");
            } else {
                echo "<br><br><div align='center'><div class='alert alert-danger'  role='alert' style='width:50%'>Vous n'avez pas noté l'activité !</div></div>";
            }

        } else if (isset($_POST['Refuser'])) {
            $uam->deleteFromTable($_SESSION['User']);
            header("Location:choisirCategorie.page.php");
        } else if (isset($_POST['Report'])) {
            $uam->reportNote($act->getId());
            header("Location:choisirCategorie.page.php");
        }
    } else {
        header("Location:../");
    }
}