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
    /**
     * Fonction générant un manager en fonction de la BDD.
     * @param PDO $database : la base de données.
     */
    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Fonction permettant de récupérer toutes les demandes d'invitation de groupe destinées à un utilisateur concerné.
     * @param User $user : l'utilisateur concerné.
     * @return array : tableau contenant toutes les invitations destinées à cet user.
     */
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

    /**
     * Fonction permettant de récupérer toutes les demandes d'invitations de groupe envoyées par un utilisateur concerné.
     * @param User $user : l'utilisateur concerné.
     * @return array : tableau contenant toutes les invitations envoyées par l'user.
     */
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

    /**
     * Fonction permettant de récupérer toutes les invitations liées à un groupe en particulier.
     * @param Groupe $groupe : le groupe concerné.
     * @return array : le tableau des invitations liées au groupe.
     */
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

    /**
     * Fonction permettant d'ajouter une invitation de groupe en base de données.
     * @param $idDemande : l'id de l'utilisateur auquel on envoie la demande.
     * @param $idEnvoi : l'id de l'user envoyant la demande.
     * @param $idGroupe : l'id du groupe concerné.
     */
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

    /**
     * Fonction permettant de supprimer toutes les invitations envoyées à un utilisateur.
     * @param User $user : l'utilisateur auquel on a envoyé les demandes.
     */
    public function deleteInvitByUserId(User $user) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_invitation where id_user_demande = :id");

        $query->execute(array(
            "id" => $user->getId(),
        ));

    }

    /**
     * Fonction permettant de supprimer toutes les invitations de groupe liées à un groupe.
     * @param Groupe $groupe : le groupe concerné.
     */
    public function deleteInvitByGroupeId(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_invitation where id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
        ));

    }

    /**
     * Fonction permettant de supprimer des invitations de groupes en fonction du groupe concerné et de l'utilisateur
     * ayant reçu cette invitation.
     * @param Groupe $groupe : le groupe concerné.
     * @param User $user : l'utilisateur ayant reçu la demande.
     */
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