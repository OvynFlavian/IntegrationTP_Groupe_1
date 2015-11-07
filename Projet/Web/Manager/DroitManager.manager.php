<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:51
 */
use \Entity\Droit as Droit;

class DroitManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getDroitById($id)
    {
        $query = $this->db->prepare("SELECT * FROM droit WHERE id = :id");
        $query->execute(array(
            ":id" => $id ,
        ));

        $tabDroit = $query->fetch(PDO::FETCH_ASSOC);

        return new Droit($tabDroit);
    }
    public function addDroit($newLabel)
    {
        $query = $this->db->prepare("INSERT INTO droit(Libelle) VALUES (:libelle)");
        $query->execute(array(
            ":libelle" => $newLabel ,
        ));
    }

    public function getAllDroit() {

            $resultats = $this->db->query("SELECT * FROM droit");
            $resultats->execute();

            $tabDroit = $resultats->fetchAll(PDO::FETCH_ASSOC);

            $tab = array();

            foreach($tabDroit as $elem)
            {
                $tab[] = new Droit($elem);
            }

            return $tab;


    }
}