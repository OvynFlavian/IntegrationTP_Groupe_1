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

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getGroupeIdByUserId(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM user_groupe WHERE id_user = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabAct = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabAct;
    }

    public function getUserIdByGroupeId(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM user_groupe WHERE id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe()
        ));

        $tabAct = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabAct;
    }

    public function addToUserGroupe(User $user, Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("INSERT INTO user_groupe(id_groupe, id_user, date) VALUES (:idGroupe , :idUser , NOW())");

        $query->execute(array(
            "idGroupe" => $groupe->getIdGroupe(),
            "idUser" => $user->getId(),
        ));
    }

    public function deleteUserGroupe(User $user) {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_groupe where id_user = :id");

        $query->execute(array(
            "id" => $user->getId(),
        ));

    }

    public function deleteGroupe(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_groupe where id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
        ));

    }
}