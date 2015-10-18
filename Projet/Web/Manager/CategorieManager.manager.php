<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 20:05
 */
use \Entity\Categorie as Categorie;

class CategorieManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllCategorie() {
        $resultats = $this->db->query("SELECT * FROM categorie");
        $resultats->execute();

        $tabUser = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabUser as $elem)
        {
            $tab[] = new Categorie($elem);
        }

        return $tab;

    }
    public function getCategorieById($id)
    {
        $query = $this->db->prepare("SELECT * FROM categorie WHERE id = :id");
        $query->execute(array(
            ":id" => $id
        ));

        $tabCategorie = $query->fetch(PDO::FETCH_ASSOC);

        return new Categorie($tabCategorie);
    }
}