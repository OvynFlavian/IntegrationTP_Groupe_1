<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:34
 */

use \Entity\Activity as Activity;

class ActivityManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllActivity() {
        $resultats = $this->db->query("SELECT * FROM activity");
        $resultats->execute();

        $tabAct = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabAct as $elem)
        {
            $tab[] = new Activity($elem);
        }

        return $tab;

    }
    public function getActivityById($id)
    {
        $query = $this->db->prepare("SELECT * FROM activity WHERE id = :id");
        $query->execute(array(
            ":id" => $id
        ));

        if ($tabAct = $query->fetch(PDO::FETCH_ASSOC)) {
            $activity = new Activity($tabAct);
        } else {
            $activity = new Activity(array());
        }

        return $activity;
    }
    public function searchAllActivityByLibelle($libelle) {

        $resultats = $this->db->prepare("SELECT * FROM activity WHERE Libelle like :lib");
        $resultats->execute(array(
            ":lib" => "%".$libelle."%"
        ));

        $tabAct = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabAct as $elem)
        {
            $tab[] = new Activity($elem);
        }

        return $tab;
    }

    public function getActivityByLibelle($lib)
    {
        $query = $this->db->prepare("SELECT * FROM activity WHERE Libelle = :lib");
        $query->execute(array(
            ":lib" => $lib
        ));

        if ($tabAct = $query->fetch(PDO::FETCH_ASSOC)) {
            $activity = new Activity($tabAct);
         } else {
            $activity = new Activity(array());
        }
        return $activity;
    }

    public function addActivity(Activity $act)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO activity(Libelle, description) VALUES (:lib, :desc)");

        $query->execute(array(
            ":lib" => $act->getLibelle(),
            ":desc" => $act->getDescription(),
        ));
    }

    public function deleteActivity($id)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM activity where id = :id");

        $query->execute(array(
            ":id" => $id,

        ));
    }
    public function signalementActivity($id, $signalement)
    {
        $query = $this
            ->db
            ->prepare("UPDATE activity SET Signalee = :signalement WHERE id = :id");
        $query->execute(array(
            ":id" => $id,
            ":signalement" => $signalement,
        ));
    }
}