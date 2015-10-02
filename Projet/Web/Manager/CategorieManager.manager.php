<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 20:05
 */

class CategorieManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
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