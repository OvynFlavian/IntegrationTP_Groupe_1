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

        $tabCat = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabCat as $elem)
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

    public function getCategorieByLibelle($lib)
    {
        $query = $this->db->prepare("SELECT * FROM categorie WHERE libelle = :lib");
        $query->execute(array(
            ":lib" => $lib
        ));

        if ($tabCat = $query->fetch(PDO::FETCH_ASSOC)) {
           $cat = new Categorie($tabCat);
        } else {
            $cat = new Categorie(array());
        }

        return $cat;
    }
}