<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 18/10/2015
 * Time: 18:40
 */
use \Entity\Activity as Activity;
use \Entity\Categorie as Categorie;

class Categorie_ActivityManager
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getActIdByCatId(Categorie $cat) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM categorie_activity WHERE id_categorie = :id_cat");

        $query->execute(array(
            "id_cat" => $cat->getId()
        ));

        $tabAct = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabAct;
    }
    public function getCatIdByActId(Activity $act) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM categorie_activity WHERE id_activity = :id_act");

        $query->execute(array(
            "id_act" => $act->getId()
        ));

        $tabCat = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabCat;
    }
    public function addToTable(Activity $act, Categorie $cat)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO categorie_activity(id_categorie, id_activity, date) VALUES (:id_cat, :id_act, NOW())");

        $query->execute(array(
            ":id_cat" => $cat->getId(),
            ":id_act" => $act->getId()
        ));
    }
    public function deleteFromTable($idAct)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM categorie_activity WHERE id_activity = :id");

        $query->execute(array(
            ":id" => $idAct,

        ));
    }

}