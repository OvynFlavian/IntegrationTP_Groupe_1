<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 19:21
 */
class ActivationManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     *
     */

    public function getActivationByLibelleAndId($libelle, $id)
    {
        $query = $this->db->prepare("SELECT * FROM activation WHERE libelle = :libelle and id_user= :id");
        $query->execute(array(
            ":libelle" => $libelle,
            ":id" => $id
        ));

        $tabAct = $query->fetch(PDO::FETCH_ASSOC);
        $tab = array();
        foreach($tabAct as $elem)
        {
            $tab[] = new Activation($elem);
        }

        return $tab;
    }
    public function getActivationById($id)
    {
        $query = $this->db->prepare("SELECT * FROM activation WHERE id_user = :id");
        $query->execute(array(
            ":id" => $id
        ));

        $tabAct = $query->fetch(PDO::FETCH_ASSOC);
        $tab = array();
        foreach($tabAct as $elem)
        {
            $tab[] = new Activation($elem);
        }

        return $tab;
    }
    public function getActivationByLibelle($libelle)
    {
        $query = $this->db->prepare("SELECT * FROM activation WHERE libelle = :libelle");
        $query->execute(array(
            ":libelle" => $libelle
        ));

        $tabAct = $query->fetch(PDO::FETCH_ASSOC);
        $tab = array();
        foreach($tabAct as $elem)
        {
            $tab[] = new Activation($elem);
        }

        return $tab;
    }

    public function addActivation(Activation $activation)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO activation(id_user, code,libelle, date) VALUES (:id_user , :code , :libelle, NOW())");

        $query->execute(array(
            ":id_user" => $activation->getIdUser(),
            ":code" => $activation->getCode(),
            ":libelle" => $activation->getLibelle()
        ));
    }

    public function deleteActivation(Activation $activation)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM activation where code= :code and id_user = :id_user and libelle = :libelle");

        $query
            ->execute(array(
                ":code" => $activation->getCode(),
                ":id_user" => $activation->getIdUser(),
                ":libelle" => $activation->getLibelle(),
            ));
    }

}