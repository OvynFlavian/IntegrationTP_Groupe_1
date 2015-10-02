<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:46
 */

class Message {
    private $id;
    private $idUserSource;
    private $idUserDest;
    private $idMessageDest;
    private $date;
    private $text;

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
    public function getIdUserSource()
    {
        return $this->idUserSource;
    }
    public function getIdUserDest()
    {
        return $this->idUserDest;
    }
    public function getIdMessageDest()
    {
        return $this->idMessageDest;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function getText()
    {
        return $this->text;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function setIdUserSource($idUserSource)
    {
        $this->idUserSource = $idUserSource;
    }
    public function setIdUserDest($idUserDest)
    {
        $this->idUserDest = $idUserDest;
    }
    public function setIdMessageDest($idMessageDest)
    {
        $this->idMessageDest = $idMessageDest;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function setText($text)
    {
        $this->text = $text;
    }

}