<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/11/2015
 * Time: 17:07
 */
use \Entity\User as User;
use \Entity\Activity as Activity;

class User_ActivityManager
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getActIdByUserId(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM user_activity WHERE id_User = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabAct = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabAct;
    }

    public function addToTable(Activity $act, User $user)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO user_activity(id_User, id_activity, date) VALUES (:id_user, :id_act, NOW())");

        $query->execute(array(
            ":id_user" => $user->getId(),
            ":id_act" => $act->getId()
        ));
    }

    public function deleteFromTable(User $user)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_activity where id_User = :id");

        $query->execute(array(
            ":id" => $user->getId(),

        ));
    }

    public function reportNote($id)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user_activity SET date = NOW() WHERE id_activity = :id");
        $query->execute(array(
            ":id" => $id
        ));
    }
        public function deleteActivity($id)
        {
            $query = $this
                ->db
                ->prepare("DELETE FROM user_activity where id_activity = :id");

            $query->execute(array(
                ":id" => $id,

            ));
        }


}