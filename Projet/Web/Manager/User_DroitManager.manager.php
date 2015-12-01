<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 7/11/2015
 * Time: 03:24
 */
use \Entity\User as User;
use \Entity\Droit as Droit;

class User_DroitManager
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
     * Fonction permettant de modifier le grade d'un utilisateur.
     * @param $idUser : l'id de l'utilsiateur concerné.
     * @param $idDroit : l'id du nouveau grade.
     */
    public function modifDroit($idUser, $idDroit)
    {
        $query = $this
            ->db
            ->prepare("UPDATE user_droit SET id_Droits = :idDroit WHERE id_User = :idUser");

        $query->execute(array(
            ":idDroit" => $idDroit,
            ":idUser" => $idUser,
        ));
    }

}