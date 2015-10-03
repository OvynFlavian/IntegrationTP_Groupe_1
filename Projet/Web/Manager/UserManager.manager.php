<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:21
 */

class UserManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     *
     */
    public function getAllUser() {
        $resultats = $this->db->query("SELECT * FROM USER");
        $resultats->execute();

        $tabUser = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabUser as $elem)
        {
            $tab[] = new User($elem);
        }

        return $tab;


    }

    public function getUserById($id)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $query->execute(array(
            ":id" => $id
        ));

        $tabUser = $query->fetch(PDO::FETCH_ASSOC);

        $userToConnect = new User($tabUser);
        $tabDroit = $this->getUserDroit($userToConnect);
        $userToConnect->setDroit($tabDroit);

        return $userToConnect;
    }
    public function getUserByUserName($userName)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE UserName = :userName");
        $query->execute(array(
            ":userName" => $userName
        ));

        $tabUser = $query->fetch(PDO::FETCH_ASSOC);

        $userToConnect = new User($tabUser);
        $tabDroit = $this->getUserDroit($userToConnect);
        $userToConnect->setDroit($tabDroit);

        return $userToConnect;
    }
    public function getUserDroit(User $user)
    {
        $query = $this->db->prepare("SELECT * FROM user_droit WHERE id_User = :idUser");
        $query->execute(array(
            ":idUser" => $user->getId()
        ));

        $tabDroit = $query->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();
        foreach($tabDroit as $elem)
        {
            $tab[] = new Droit($elem);
        }

        return $tab;
    }

    public function addUser(User $user)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO user(UserName, Mdp, DateInscription) VALUES (:username , :mdp , NOW())");

        $query->execute(array(
            ":username" => $user->getUserName(),
            ":mdp" => $user->getMdp(),
        ));
    }

    public function updateUserProfil(User $user)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user SET UserName = :username , Mdp = :mdp , Tel = :tel WHERE id = :id");

        $query
            ->execute(array(
                ":id" => $user->getId(),
                ":username" => $user->getUserName(),
                ":mdp" => $user->getMdp(),
                ":tel" => $user->getTel(),
            ));
    }

}