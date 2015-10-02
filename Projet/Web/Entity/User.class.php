<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:14
 */

class User{
    private $id;
    private $UserName;
    private $Mdp;
    private $tel;
    private $DateInscription;
    private $DateLastIdea;
    private $DateLastConnect;
    private $droit = array();

    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            $method = 'set'. $key;
            if(method_exists($this,$method))$this->$method($value);
        }
    }
    public function __construct(array $user)
    {
        $this->__hydrate($user);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUserName()
    {
        return $this->UserName;
    }
    public function getMdp()
    {
        return $this->Mdp;
    }
    public function getDateInscription()
    {
        return $this->DateInscription;
    }
    public function getDateLastIdea()
    {
        return $this->DateLastIdea;
    }
    public function getDateLastConnect()
    {
        return $this->DateLastConnect;
    }
    public function getDroit()
    {
        return $this->droit;
    }
    public function getTel()
    {
        return $this->tel;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUserName($UserName)
    {
        $this->UserName = $UserName;
    }
    public function setMdp($Mdp)
    {
        $this->Mdp = $Mdp;
    }
    public function setDateInscription($DateInscription)
    {
        $this->DateInscription = $DateInscription;
    }
    public function setDateLastIdea($DateLastIdea)
    {
        $this->DateLastIdea = $DateLastIdea;
    }
    public function setDateLastConnect($DateLastConnect)
    {
        $this->DateLastConnect = $DateLastConnect;
    }
    public function setDroit(array $droit)
    {
        $this->droit = $droit;
    }
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

}