<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 23:08
 */
use \Entity\User as User;
use \Entity\Amis as Amis;

function gererDemande() {

        if (isset($_POST['Accepter'])) {
            ajoutDemande();
            return "Votre demande a bien été envoyée à l'utilisateur concerné !";
        } else if (isset($_POST['Refuser'])) {
            return "Erreur";
        }

}

function ajoutDemande() {

    $id = $_GET['membre'];
    $idUser = $_SESSION['User']->getId();

    $demandeAmis = new Amis(array(
        "id_user_1" => $idUser,
        "id_user_2" => $id,
    ));
    $am = new AmisManager(connexionDb());
    $demandeExistante = $am->getAmisById1AndId2($idUser, $id);
    if ($demandeExistante->getDate() != NULL) {
        $am->deleteAmis($demandeAmis);
    }
    $demandeAmis->setAccepte(0);

    $am->addAmis($demandeAmis);
}