<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 22:30
 */
use \Entity\Groupe as Groupe;
use \Entity\User as User;

class GroupeManager {
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
     * Fonction permettant de retrouver un groupe en fonction de l'user qui est son leader.
     * @param User $user : utilisateur ayant le lead du groupe.
     * @return Groupe : la classe groupe concernée.
     */
    public function getGroupeByLeader(User $user) {
        $resultats = $this->db->prepare("SELECT * FROM groupe WHERE id_leader = :id");
        $resultats->execute(array(
            ":id" => $user->getId(),
        ));

        if ($tabGroupe = $resultats->fetch(PDO::FETCH_ASSOC)) {
            $groupe = new Groupe($tabGroupe);
        } else {
            $groupe = new Groupe(array());
        }

        return $groupe;

    }

    /**
     * Fonction renvoyant un tableau de tous les groupes contenus en BDD.
     * @return array : tableau contenant tous les groupes.
     */
    public function getAllGroupe() {
        $resultats = $this->db->prepare("SELECT * FROM groupe");
        $resultats->execute();

        $tabGroupe = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabGroupe as $elem)
        {
            $groupe = new Groupe($elem);
            $tab[] = $groupe;

        }

        return $tab;

    }

    /**
     * Fonction permettant de récupérer tous els groupes concernant une activité donnée.
     * @param $id : l'id de l'activité concernée.
     * @return array : tableau de la liste des groupes concernant cette activité.
     */
    public function getAllGroupeByAct($id) {
        $resultats = $this->db->prepare("SELECT * FROM groupe WHERE id_activity = :act");
        $resultats->execute(array(
            ":act" => $id,
        ));

        $tabGroupe = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabGroupe as $elem)
        {
            $groupe = new Groupe($elem);
            $tab[] = $groupe;

        }

        return $tab;

    }

    /**
     * Fonction permettant de récupérer un groupe en fonction de son id.
     * @param $id : l'id du groupe.
     * @return Groupe : la classe du groupe concerné.
     */
    public function getGroupeByIdGroupe($id) {
        $resultats = $this->db->prepare("SELECT * FROM groupe WHERE id_groupe = :id");
        $resultats->execute(array(
            ":id" => $id,
        ));

        if ($tabGroupe = $resultats->fetch(PDO::FETCH_ASSOC)) {
            $groupe = new Groupe($tabGroupe);
        } else {
            $groupe = new Groupe(array());
        }

        return $groupe;

    }

    /**
     * Fonction permettant de récupérer la liste des groupes pour une activité donnée.
     * @param $id : l'id de l'activité.
     * @return array : la liste des groupes concernant cette activité.
     */
    public function getGroupeByIdActivity($id) {
        $resultats = $this->db->prepare("SELECT * FROM groupe WHERE id_activity = :id");
        $resultats->execute(array(
            ":id" => $id,
        ));

        $tabGroupe = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabGroupe as $elem)
        {
            $tab[] = new Groupe($elem);
        }

        return $tab;

    }

    /**
     * Fonction permettant d'ajouter un groupe en BDD.
     * @param Groupe $groupe : la classe groupe que l'on désire ajouter.
     */
    public function addGroupe(Groupe $groupe)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO groupe(id_leader, date, description, id_activity) VALUES (:idLeader , NOW(), :desc, :idAct)");

        $query->execute(array(
            ":idLeader" => $groupe->getIdLeader(),
            ":desc" => $groupe->getDescription(),
            ":idAct" => $groupe->getIdActivity(),
        ));
    }

    /**
     * Fonction permettant de supprimer un groupe en fonction de son leader.
     * @param $idUser : id du leader du groupe.
     */
    public function deleteGroupe($idUser) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe where id_leader = :id");

        $query->execute(array(
            ":id" => $idUser,

        ));
    }

    /**
     * Fonction permettant de mettre à jour la description d'un groupe.
     * @param Groupe $groupe : le groupe à modifier.
     * @param $desc: la nouvelle description du groupe.
     */
    public function updateGroupeDesc(Groupe $groupe, $desc)
    {
        $query = $this
            ->db
            ->prepare("UPDATE groupe SET description = :desc WHERE id_groupe = :id");

        $query
            ->execute(array(
                ":id" => $groupe->getIdGroupe(),
                ":desc" => $desc,
            ));

    }

    /**
     * Fonction permettant de changer le leader d'un groupe.
     * @param Groupe $groupe : le groupe concerné.
     * @param $id : id du nouveau leader.
     */
    public function updateLeader(Groupe $groupe, $id)
    {
        $query = $this
            ->db
            ->prepare("UPDATE groupe SET id_leader = :idLead WHERE id_groupe = :id");

        $query
            ->execute(array(
                ":id" => $groupe->getIdGroupe(),
                ":idLead" => $id,
            ));

    }
}