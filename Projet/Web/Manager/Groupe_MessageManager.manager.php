<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 19:21
 */


use \Entity\Groupe as Groupe;
use \Entity\User as User;

class Groupe_MessageManager{
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
     * Fonction permettant de récupérer tous les messages d'un groupe voulu.
     * @param Groupe $groupe : le groupe concerné par les messages.
     * @return array : le tableau de messages concernant le groupe.
     */
    public function getMessageByGroup(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_message WHERE id_groupe = :id ORDER BY date DESC");

        $query->execute(array(
            "id" => $groupe->getIdGroupe()
        ));

        $tabMess = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabMess;
    }

    /**
     * Fonction permettant de retrouver tous les messages de groupe d'un utilisateur en particulier.
     * @param User $user : l'utilisateur concerné.
     * @return array : tableau contenant tous les messages de l'utilisateur.
     */
    public function getMessageByUser(User $user) {
        $query = $this
            ->db
            ->prepare("SELECT * FROM groupe_message WHERE id_user = :id");

        $query->execute(array(
            "id" => $user->getId()
        ));

        $tabMess = $query->fetchAll(PDO::FETCH_ASSOC);


        return $tabMess;
    }

    /**
     * Fonction permettant d'ajouter un message à un groupe concerné en BDD.
     * @param Groupe $groupe : le groupe concerné.
     * @param User $user : l'utilisateur envoyant le message.
     * @param $desc : le contenu du message.
     */
    public function addMess(Groupe $groupe, User $user, $desc) {
        $query = $this
            ->db
            ->prepare("INSERT INTO groupe_message(id_groupe, id_user, description, date ) VALUES (:id_groupe , :id_user, :desc , NOW())");

        $query->execute(array(
            "id_groupe" => $groupe->getIdGroupe(),
            "id_user" => $user->getId(),
            "desc" => $desc,
        ));
    }

    /**
     * Fonction permettant de supprimer tous les messages d'un groupe supprimé.
     * @param Groupe $groupe : le groupe supprimé.
     */
    public function deleteMessByGroupe(Groupe $groupe) {
        $query = $this
            ->db
            ->prepare("DELETE FROM groupe_message where id_groupe = :id");

        $query->execute(array(
            "id" => $groupe->getIdGroupe(),
        ));

    }


}
