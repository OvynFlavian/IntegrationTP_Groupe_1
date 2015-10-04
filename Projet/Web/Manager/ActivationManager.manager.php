<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 19:21
 */

/**
 * Class ActivationManager
 * Controlleur de la base de donnée lié au code d'activation
 */
class ActivationManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Méthode permettant la récupération des codes d'activation lié à un libellé et a un user
     * @param string $libelle du code d'activation
     * @param int $id le user lié au code d'activation
     * @return array associatif dont chaque élément est un code d'activation
     */
    public function getActivationByLibelleAndId($libelle, $id)
    {
        $query = $this->db->prepare("SELECT * FROM activation WHERE libelle = :libelle and id_user= :id");
        $query->execute(array(
            ":libelle" => $libelle,
            ":id" => $id
        ));

        $tabAct = $query->fetchAll(PDO::FETCH_ASSOC);
        $tab = array();
        foreach($tabAct as $elem)
        {
            $tab[] = new Activation($elem);
        }

        return $tab;
    }

    /**
     * Méthode permettant la récupération des codes d'activation lié à un user
     * @param int $id de l'utilisateur que l'on recherche
     * @return array
     */
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
    public function getActivationByCodeAndLibelle($libelle, $code)
    {
        $query = $this->db->prepare("SELECT * FROM activation WHERE libelle = :libelle and code = :code");
        $query->execute(array(
            ":libelle" => $libelle,
            ":code" => $code,
        ));

        $tabActi = $query->fetch(PDO::FETCH_ASSOC);

        $codeRenvoi = new Activation($tabActi);

        return $codeRenvoi;
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

    public function deleteActivationByIdAndLibelle($id, $libelle) {
        $query = $this
            ->db
            ->prepare("DELETE FROM activation where id_user = :id and libelle = :libelle");

        $query
            ->execute(array(
                ":id" => $id,
                ":libelle" => $libelle,
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