<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:21
 */

use \Entity\User as User;

class UserManager {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    /**
     * Méthode permettant la récupération de tous les utilisateurs
     * @return array $tab contentant tous les users
     */
    public function getAllUser() {
        $resultats = $this->db->query("SELECT * FROM user");
        $resultats->execute();

        $tabUser = $resultats->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();

        foreach($tabUser as $elem)
        {
            $tab[] = new User($elem);
        }

        return $tab;

    }

    public function searchAllUserByName($name) {

        $resultats = $this->db->prepare("SELECT * FROM user WHERE UserName like :userName");
        $resultats->execute(array(
            ":userName" => "%".$name."%"
        ));

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

        if($tabUser = $query->fetch(PDO::FETCH_ASSOC))
        {
            $userToConnect = new User($tabUser);
            $tabDroit = $this->getUserDroit($userToConnect);
            $userToConnect->setDroit($tabDroit);
        }
        else
        {
            $userToConnect = new User(array());
        }
        return $userToConnect;
    }
    public function getUserByEmail($email)
    {
        $query = $this
            ->db
            ->prepare("SELECT * FROM user WHERE email = :email");
        $query->execute(array(
            ":email" => $email
        ));

        if($tabUser = $query->fetch(PDO::FETCH_ASSOC))
        {
            $userToConnect = new User($tabUser);
            $tabDroit = $this->getUserDroit($userToConnect);
            $userToConnect->setDroit($tabDroit);
        }
        else
        {
            $userToConnect = new User(array());
        }

        return $userToConnect;
    }
    public function getUserDroit(User $user)
    {
        $dm = new DroitManager(connexionDb());
        $query = $this->db->prepare("SELECT * FROM user_droit WHERE id_User = :idUser");
        $query->execute(array(
            ":idUser" => $user->getId()
        ));

        $tabDroit = $query->fetchAll(PDO::FETCH_ASSOC);

        $tab = array();
        foreach($tabDroit as $elem)
        {
            $droitUser = $dm->getDroitById($elem['id_Droits']);
            $tab[] = $droitUser;

        }
        return $tab;
    }

    public function setUserDroit(User $user, $droits)
    {
        $query = $this->db->prepare("INSERT INTO user_droit(id_Droits, id_User, Date) values (:idDroits, :idUser, NOW())");
        $query->execute(array(
            ":idUser" => $user->getId(),
            ":idDroits" => $droits
        ));
    }

    public function addUser(User $user)
    {
        $query = $this
            ->db
            ->prepare("INSERT INTO user(UserName, Mdp, DateInscription, DateLastConnect, email) VALUES (:username , :mdp , NOW(),NOW(), :email)");
        $user-> setMdp(hash("sha256", $user->getMdp()));
        $query->execute(array(
            ":username" => $user->getUserName(),
            ":mdp" => $user->getMdp(),
            ":email" => $user->getEmail(),
        ));
    }

    public function updateUserProfil(User $user)
    {

            $query = $this
                ->db
                ->prepare("UPDATE user SET UserName = :username , Mdp = :mdp , email = :email, tel = :tel WHERE id = :id");

            $query
                ->execute(array(
                    ":id" => $user->getId(),
                    ":username" => $user->getUserName(),
                    ":email" => $user->getEmail(),
                    ":mdp" => $user->getMdp(),
                    ":tel" => $user->getTel(),
                ));


    }

    public function updateUserConnect(User $user)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user SET DateLastConnect = NOW() WHERE id = :id");

        $query
            ->execute(array(
                ":id" => $user->getId(),
            ));

    }
    public function updateUserLastIdea(User $user)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user SET DateLastIdea = NOW() WHERE id = :id");

        $query
            ->execute(array(
                ":id" => $user->getId(),
            ));

    }

    public function updateUserMdp (User $user) {

        $query = $this
            -> db
            ->prepare("UPDATE user SET Mdp = :mdp where id = :id");
        $user->setMdp(hash("sha256", $user->getMdp()));
        $query
            ->execute(array(
                ":id" => $user->getId(),
                ":mdp" => $user->getMdp(),
            ));
    }

}