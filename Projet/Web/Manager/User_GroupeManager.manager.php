<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 22:43
 */
use \Entity\User as User;
use \Entity\Groupe as Groupe;

class User_GroupeManager {

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
     * Fonction permettant de récupérer l'id du groupe en fonction de l'id du membre.
     * @param User $user : l'utilisateur appartenant au groupe.
     * @return array : tableau comprenant l'id du groupe du membre.
     */
    public function getGroupeIdByUserId(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM user_groupe WHERE id_user = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabGroupe = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabGroupe;
    }

    /**
     * Fonction permettant de récupérer l'id des utilisateurs appartenant à un groupe donné.
     * @param Groupe $groupe : le groupe concerné.
     * @return array : tableau contenant les id des utilisateurs du groupe.
     */
    public function getUserIdByGroupeId(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM user_groupe WHERE id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe()
        ));

        $tabUser = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabUser;
    }

    /**
     * Fonction permettant d'ajouter un utilisateur à un groupe.
     * @param User $user : l'utilisateur à ajouter.
     * @param Groupe $groupe : le groupe concerné.
     */
    public function addToUserGroupe(User $user, Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("INSERT INTO user_groupe(id_groupe, id_user, date) VALUES (:idGroupe , :idUser , NOW())");

        $query->execute(array(
            "idGroupe" => $groupe->getIdGroupe(),
            "idUser" => $user->getId(),
        ));
    }

    /**
     * Fonction permettant de supprimer l'appartenance d'un utilisateur à un groupe.
     * @param User $user : l'utilisateur à supprimer.
     */
    public function deleteUserGroupe(User $user) {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_groupe where id_user = :id");

        $query->execute(array(
            "id" => $user->getId(),
        ));

    }

    /**
     * Fonction permettant de supprimer tous les utilisateurs liés à un groupe.
     * @param Groupe $groupe : le groupe concerné.
     */
    public function deleteGroupe(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_groupe where id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
        ));

    }
}