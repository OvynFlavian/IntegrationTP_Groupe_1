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
    /**
     * Fonction générant un manager en fonction de la BDD.
     * @param PDO $database : la base de données.
     */
    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Fonction permettant de ramener toutes les classes Activity de la BDD.
     * @return array : le tableau contenant toutes les activités.
     */
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

    /**
     * Fonction permettant d'aller rechercher une activité en BDD grâce à son id.
     * @param $id : l'id de l'activité.
     * @return Activity : la classe Activity de l'activité.
     */
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

    /**
     * Fonction permettant de ramener toutes les activités contenues en BDD dont le libellé contient le string donné.
     * @param $libelle : le string contenu dans le libelle.
     * @return array : le tableau d'activité dont le libellé contient ce string.
     */
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

    /**
     * Fonction permettant de récupérer une activité en BDD grâce à son libellé.
     * @param $lib : le libellé de l'activité.
     * @return Activity : la classe Activity de l'activité.
     */
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

    /**
     * Fonction permettant d'ajouter la classe Activity voulue en BDD
     * @param Activity $act : la classe activity que l'on veut ajouter.
     */
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

    /**
     * Fonction permettant de supprimer l'activité voulue en BDD en fonction de son id.
     * @param $id : l'id de l'activité à supprimer.
     */
    public function deleteActivity($id)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM activity where id = :id");

        $query->execute(array(
            ":id" => $id,

        ));
    }

    /**
     * Fonction permettant de marquer comme signalée ou désignalée une activité en BDD.
     * @param $id : l'id de l'activité.
     * @param $signalement : son signalement.
     */
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

    /**
     * Fonction permettant de modifier la note d'une activité en BDD.
     * @param $id : l'id de l'activité.
     * @param $cote : sa nouvelle note.
     * @param $votants : le nouveau nombre de votants
     */
    public function updateCote($id, $cote, $votants)
    {
        $query = $this
            ->db
            ->prepare("UPDATE activity SET note = :note, votants = :votants WHERE id = :id");
        $query->execute(array(
            ":id" => $id,
            ":note" => $cote,
            ":votants" => $votants,
        ));
    }

    /**
     * Fonction permettant de mettre à jour le libellé et la description d'une activité en BDD.
     * @param Activity $activite : la classe Activity modifiée.
     */
    public function updateActivite(Activity $activite)
    {
        $query = $this
            ->db
            ->prepare("UPDATE activity SET Libelle = :lib, description = :desc  WHERE id = :id");
        $query->execute(array(
            ":id" => $activite->getId(),
            ":desc" => $activite->getDescription(),
            ":lib" => $activite->getLibelle(),
        ));
    }


}