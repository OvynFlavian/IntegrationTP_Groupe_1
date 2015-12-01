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
    /**
     * Fonction générant un manager en fonction de la BDD.
     * @param PDO $database : la base de données.
     */
    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Fonction permettant de retrouver l'id de l'activité effectuée par un user.
     * @param User $user : l'utilisateur effectuant l'activité.
     * @return array : tableau contenant l'id de l'activité qu'il effectue.
     */
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

    /**
     * Fonction permettant d'ajouter en BDD un lien entre l'id de l'activité et l'id de l'utilisateur l'effectuant.
     * @param Activity $act : l'activité effectuée.
     * @param User $user : l'utilisateur effectuant l'activité.
     */
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

    /**
     * Fonction permettant de supprimer un lien entre une activité et un utilisateur.
     * @param User $user : l'utilisateur concerné.
     */
    public function deleteFromTable(User $user)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_activity where id_User = :id");

        $query->execute(array(
            ":id" => $user->getId(),

        ));
    }

    /**
     * Fonction permettant de reporter le temps auquel l'utilisateur pourra renoter l'activité.
     * @param $id : id de l'utilisateur effectuant l'activité.
     */
    public function reportNote($id)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user_activity SET date = NOW() WHERE id_User = :id");
        $query->execute(array(
            ":id" => $id
        ));
    }

    /**
     * Fonction permettant de supprimer tous les liens entre les utilisateurs et une activité donnée.
     * @param $id : id de l'activité supprimée.
     */
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