<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:30
 */

class Droit {
    private $id;
    private $Libelle;

    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            $method = 'set'. $key;
            if(method_exists($this,$method))$this->$method($value);
        }
    }
    public function __construct(array $droit)
    {
        $this->__hydrate($droit);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getLibelle()
    {
        return $this->Libelle;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setLibelle($Libelle)
    {
        $this->Libelle = $Libelle;
    }

}