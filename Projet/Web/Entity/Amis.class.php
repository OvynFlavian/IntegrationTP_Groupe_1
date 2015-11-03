<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 23:30
 */

namespace Entity;
/**
 * Class Amis
 * Entité de la base de donnée définissant une activité proposé.
 */

class Amis {
    private $id_user_1;
    private $id_user_2;
    private $date;
    private $accepte;

    /**
     * Fonction permettant l'hydratation de la classe.
     * @param array $tab est un tableau associatif selon les attributs a assigner.
     */
    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            if(property_exists($this,$key))$this->$key = $value;
        }
    }
    public function __construct(array $amis)
    {
        $this->__hydrate($amis);
    }


    public function getIdUser1()
    {
        return $this->id_user_1;
    }
    public function setIdUser1($id_user_1)
    {
        $this->id_user_1 = $id_user_1;
    }
    public function getIdUser2()
    {
        return $this->id_user_2;
    }
    public function setIdUser2($id_user_2)
    {
        $this->id_user_1 = $id_user_2;
    }


    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getAccepte() {
        return $this->accepte;
    }
    public function setAccepte($accepte) {
        $this->accepte = $accepte;
    }
}