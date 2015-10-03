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

    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            $method = 'set'. $key;
            if(method_exists($this,$method))$this->$method($value);
        }
    }
    public function __construct(array $activation)
    {
        $this->__hydrate($activation);
    }

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