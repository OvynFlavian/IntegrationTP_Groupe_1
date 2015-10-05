<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 5/10/2015
 * Time: 09:08
 */

class UserFixture {
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function initTable()
    {
        $adminConf = getConfigFile();
        $query = $this
            ->db
            ->prepare(
                "INSERT INTO user(UserName,Mdp,DateInscription,email,Tel) VALUES (:username , :mdp , NOW() , :email , :tel);
                 INSERT INTO user_droit(id_Droits, id_User, Date) VALUES (1,1,NOW());"
            );

        $admin = new User(array(
            "UserName" => $adminConf['pseudo'],
            "Mdp" => "admin",
            "email" => $adminConf['mail'],
            "tel" => $adminConf['tel']
        ));

        $admin->setHashMdp();

        $query->execute(array(
            ":username" => $admin->getUserName(),
            ":mdp" => $admin->getMdp(),
            ":email" => $admin->getEmail(),
            ":tel" => $admin->getTel()
        ));
    }

    public function deleteAllUser()
    {
        $query = $this
            ->db
            ->prepare("DELETE FROM user_droit; DELETE FROM user");
        $query->execute();
    }
}