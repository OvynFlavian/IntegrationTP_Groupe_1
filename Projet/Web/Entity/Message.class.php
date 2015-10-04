<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:46
 */

/**
 * Class Message
 * Entité de la base de donnée définissant les messages transmits a partir du site
 */
class Message {
    private $id;
    private $idUserSource;
    private $idUserDest;
    private $idMessageDest;
    private $date;
    private $text;

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
    public function __construct(array $droit)
    {
        $this->__hydrate($droit);
    }

    /**GETTER*/
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

    /**SETTER**/
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