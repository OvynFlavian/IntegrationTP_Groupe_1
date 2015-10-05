<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:30
 */

class Activation {
    private $id_user;
    private $code;
    private $libelle;

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
    public function __construct(array $activation)
    {
        $this->__hydrate($activation);
    }

    /**GETTER**/
    public function getIdUser()
    {
        return $this->id_user;
    }
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**SETTER**/
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

}