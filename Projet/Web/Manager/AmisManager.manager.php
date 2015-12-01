<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 23:34
 */

use \Entity\Amis as Amis;

/**
 * Class ActivationManager
 * Controlleur de la base de donnée lié au code d'activation
 */
class AmisManager
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
     * Récupère tous les amis en base de données grâce à l'id de l'utilisateur envoyant la demande.
     * @param $id1 : l'id de l'utilsateur ayant envoyé la demande.
     * @return array : un tableau contenant toutes les demandes d'amis liées à cet utilisateur.
     */
    public function getAmisByIdUser1($id1) {

        $resultats = $this->db->prepare("SELECT * FROM amis WHERE id_user_1 = :id1");
        $resultats->execute(array(
            ":id1" => $id1,
        ));

        $tabUser = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabUser as $elem)
        {
            $tab[] = new Amis($elem);
        }

        return $tab;
    }

    /**
     * Récupère tous les amis en base de données grâce à l'id de l'utilisateur ayant reçu la demande.
     * @param $id2 : l'id de l'utilisateur ayant envoyé la demande.
     * @return array : le tableau contenant toutes les demandes d'ami liées à cet utilisateur.
     */
    public function getAmisByIdUser2($id2) {

        $resultats = $this->db->prepare("SELECT * FROM amis WHERE id_user_2 = :id2");
        $resultats->execute(array(
            ":id2" => $id2,
        ));

        $tabUser = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabUser as $elem)
        {
            $tab[] = new Amis($elem);
        }

        return $tab;
    }

    /**
     * Fonction permettant de récupérer en base de données une demande d'ami entre deux utilisateurs précis.
     * @param $id1 : l'id de l'utilisateur 1.
     * @param $id2 : l'id de l'utilisateur 2.
     * @return Amis : le demande d'ami concernant ces deux utilisateurs.
     */
    public function getAmisById1AndId2($id1, $id2)
    {
        $query = $this->db->prepare("SELECT * FROM amis WHERE id_user_1 = :id1 and id_user_2 = :id2");
        $query->execute(array(
            ":id1" => $id1,
            ":id2" => $id2
        ));

        if ($tabAmis = $query->fetch(PDO::FETCH_ASSOC)) {
            $amis = new Amis($tabAmis);
        } else {
            $amis = new Amis(array());
        }
        return $amis;
    }

    /**
     * Fonction ajoutant la demande d'ami entre deux utilisateurs.
     * @param Amis $amis : la demande d'ami à ajouter.
     */
    public function addAmis(Amis $amis)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO amis(id_user_1, id_user_2, date, accepte) VALUES (:id1 , :id2 , NOW(), :accepte)");
        $query->execute(array(
            ":id1" => $amis->getIdUser1(),
            ":id2" => $amis->getIdUser2(),
            ":accepte" => $amis->getAccepte(),
        ));
    }

    /**
     * Fonction permettant de marquer la demande d'ami entre deux membres comme acceptée.
     * @param Amis $amis : la demande d'ami acceptée.
     */
    public function updateAmisAccepte(Amis $amis)
    {
        $query = $this
            ->db
            ->prepare("UPDATE amis SET accepte = :accepte WHERE id_user_1 = :id1 AND id_user_2= :id2");

        $query->execute(array(
            ":id1" => $amis->getIdUser1(),
            ":id2" => $amis->getIdUser2(),
            ":accepte" => $amis->getAccepte(),
        ));

    }

    /**
     * Fonction permettant de supprimer la demande d'ami voulue.
     * @param Amis $amis : la demande d'ami concernée.
     */
    public function deleteAmis(Amis $amis)
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM amis where id_user_1= :id1 and id_user_2 = :id2");

        $query->execute(array(
            ":id1" => $amis->getIdUser1(),
            ":id2" => $amis->getIdUser2(),

        ));
    }
}