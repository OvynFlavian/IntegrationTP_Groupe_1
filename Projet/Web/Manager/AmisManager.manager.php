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

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

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