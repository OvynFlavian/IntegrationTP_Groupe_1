<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:21
 */

class UserManager {
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function getUserById($id)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $query->execute(array(
            ":id" => $id
        ));

        $tabUser = $query->fetch(PDO::FETCH_ASSOC);

        return new User($tabUser);
    }
    public function getUserByUserName($userName)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE UserName = :userName");
        $query->execute(array(
            ":userName" => $userName
        ));

        $tabUser = $query->fetch(PDO::FETCH_ASSOC);

        return new User($tabUser);
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

        $user->setDroit($tab);
    }

    public function addUser(User $user)
    {
        $query = $this->db->prepare("INSERT INTO user(UserName, Mdp, DateInscription) VALUES (:username , :mdp , NOW())");
        $query->execute(array(
            ":userName" => $user->getUserName(),
            ":mdp" => hash("sha256", $user->getMdp()),
        ));
    }

}