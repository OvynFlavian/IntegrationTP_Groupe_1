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
    /**
     * Fonction générant un manager en fonction de la BDD.
     * @param PDO $database : la base de données.
     */
    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Fonction permettant de retrouver toutes les id d'activité en fonction de l'id de la catégorie concernée.
     * @param Categorie $cat : la catégorie concernée.
     * @return array : le tableau contenant les id des activités concernées.
     */
    public function getActIdByCatId(Categorie $cat) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM categorie_activity WHERE id_categorie = :id_cat");

        $query->execute(array(
            "id_cat" => $cat->getId()
        ));

        $tabAct = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabAct;
    }

    /**
     * Fonction permettant de retrouver l'id de la catégorie concernant l'activité concernée.
     * @param Activity $act : l'activité concernée.
     * @return array : tableau contenant l'id de la catégorie de l'activité.
     */
    public function getCatIdByActId(Activity $act) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM categorie_activity WHERE id_activity = :id_act");

        $query->execute(array(
            "id_act" => $act->getId()
        ));

        $tabCat = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabCat;
    }

    /**
     * Fonction permettant d'ajouter en BDD un lien entre l'id de la catégorie et l'id de l'activité.
     * @param Activity $act : l'activité concernée.
     * @param Categorie $cat : la catégorie de l'activité.
     */
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

    /**
     * Fonction permettant de supprimer en BDD le lien entre l'id d'une catégorie et l'id d'une activité.
     * @param $idAct : l'id de l'activité supprimée.
     */
    public function deleteFromTable($idAct)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM categorie_activity WHERE id_activity = :id");

        $query->execute(array(
            ":id" => $idAct,

        ));
    }

    /**
     * Fonction permettant de modifier l'id de la catégorie concernant l'activité voulue.
     * @param Activity $activite : l'activité changeant de catégorie.
     * @param $id : l'id de la nouvelle catégorie.
     */
    public function updateCategorie(Activity $activite, $id)
    {
        $query = $this
            ->db
            ->prepare("UPDATE categorie_activity SET id_categorie = :cat  WHERE id_activity = :act");
        $query->execute(array(
            ":cat" => $id,
            ":act" => $activite->getId(),
        ));
    }
}