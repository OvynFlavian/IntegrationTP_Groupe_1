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

}