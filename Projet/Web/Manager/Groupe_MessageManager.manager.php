<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 19:21
 */


use \Entity\Groupe as Groupe;
use \Entity\User as User;

class Groupe_MessageManager{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getMessageByGroup(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_message WHERE id_groupe = :id ORDER BY date DESC");

        $query->execute(array(
            "id" => $groupe->getIdGroupe()
        ));

        $tabMess = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabMess;
    }

    public function getMessageByUser(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_message WHERE id_user = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabMess = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabMess;
    }

    public function addMess(Groupe $groupe, User $user, $desc) {
        $query = $this
            ->db
            ->prepare("INSERT INTO groupe_message(id_groupe, id_user, description, date ) VALUES (:id_groupe , :id_user, :desc , NOW())");

        $query->execute(array(
            "id_groupe" => $groupe->getIdGroupe(),
            "id_user" => $user->getId(),
            "desc" => $desc,
        ));
    }

    public function deleteMessByGroupe(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_message where id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
        ));

    }


}
