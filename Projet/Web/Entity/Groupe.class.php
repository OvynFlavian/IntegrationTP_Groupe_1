<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 22:34
 */

namespace Entity;
/**
 * Class Groupe
 * Entité de la base de donnée définissant un groupe.
 */

class Groupe {
    private $id_groupe;
    private $id_leader;
    private $date;
    private $description;
    private $id_activity;

    /**
     * Fonction permettant l'hydratation de la classe.
     * @param array $tab est un tableau associatif selon les attributs a assigner.
     */
    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            if(property_exists($this,$key))$this->$key = $value;
        }
    }
    public function __construct(array $groupe)
    {
        $this->__hydrate($groupe);
    }


    public function getIdGroupe()
    {
        return $this->id_groupe;
    }
    public function setIdGroupe($id_groupe)
    {
        $this->id_groupe = $id_groupe;
    }
    public function getIdLeader()
    {
        return $this->id_leader;
    }
    public function setIdLeader($id_leader)
    {
        $this->id_leader = $id_leader;
    }


    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;
    }

    public function getIdActivity() {
        return $this->id_activity;
    }
    public function setIdActivity($id_activity) {
        $this->id_activity = $id_activity;
    }
}