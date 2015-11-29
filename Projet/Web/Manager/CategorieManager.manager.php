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
    /**
     * Fonction générant un manager en fonction de la BDD.
     * @param PDO $database : la base de données.
     */
    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Fonction permettant de récupérer toutes les catégories présentes en BDD.
     * @return array : le tableau contenant toutes les catégories.
     */
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

    /**
     * Fonction permettant de récupérer une catégorie en BDD en fonction de son id.
     * @param $id : l'id de la catégorie voulue.
     * @return Categorie : la classe Catégorie de la catégorie concernée.
     */
    public function getCategorieById($id)
    {
        $query = $this->db->prepare("SELECT * FROM categorie WHERE id = :id");
        $query->execute(array(
            ":id" => $id
        ));

        $tabCategorie = $query->fetch(PDO::FETCH_ASSOC);

        return new Categorie($tabCategorie);
    }

    /**
     * Fonction permettant de récupérer une catégorie en BDD en fonction de son libellé.
     * @param $lib : le libellé de la catégorie.
     * @return Categorie : la clase Catégorie de la catégorie concernée.
     */
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