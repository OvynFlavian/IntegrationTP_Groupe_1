<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 23/11/2015
 * Time: 20:54
 */

use \Entity\Groupe as Groupe;
use \Entity\User as User;

class Groupe_InvitationManager{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getInvitationByDemande(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_invitation WHERE id_user_demande = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabInv = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabInv;
    }

    public function getInvitationByEnvoi(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_invitation WHERE id_user_envoi = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabInv = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabInv;
    }
    public function getInvitationByGroupe(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_invitation WHERE id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe()
        ));

        $tabInv = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabInv;
    }

    public function addInvit($idDemande, $idEnvoi, $idGroupe) {
        $query = $this
            ->db
            ->prepare("INSERT INTO groupe_invitation(id_user_demande, id_user_envoi, id_groupe, accepte ) VALUES (:idDemande , :idEnvoi, :idGroupe , 0)");

        $query->execute(array(
            "idDemande" => $idDemande,
            "idEnvoi" => $idEnvoi,
            "idGroupe" => $idGroupe
        ));
    }

    public function deleteInvitByUserId(User $user) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_invitation where id_user_demande = :id");

        $query->execute(array(
            "id" => $user->getId(),
        ));

    }

    public function deleteInvitByGroupeId(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_invitation where id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
        ));

    }
    public function deleteInvitByGroupeIdAndUserId(Groupe $groupe, User $user) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_invitation where id_groupe = :id and id_user_demande = :idDemande");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
            "idDemande" => $user->getId(),
        ));


    }
}