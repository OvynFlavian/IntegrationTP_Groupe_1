<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:40
 */

class Activity {
    private $id;
    private $Libelle;
    private $Signalee;
    private $ByGroup;

    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            $method = 'set'. $key;
            if(method_exists($this,$method))$this->$method($value);
        }
    }
    public function __construct(array $activity)
    {
        $this->__hydrate($activity);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getLibelle()
    {
        return $this->Libelle;
    }
    public function getSignalee()
    {
        return $this->Signalee;
    }
    public function getByGroup()
    {
        return $this->ByGroup;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setLibelle($Libelle)
    {
        $this->Libelle = $Libelle;
    }
    public function setSignalee($Signalee)
    {
        $this->Signalee = $Signalee;
    }
    public function setByGroup($ByGroup)
    {
        $this->ByGroup = $ByGroup;
    }

}