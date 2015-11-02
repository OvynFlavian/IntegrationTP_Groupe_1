<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:40
 */
namespace Entity;

/**
 * Class Activity
 * Entité de la base de donnée définissant une activité proposé.
 */
class Activity {
    private $id;
    private $Libelle;
    private $Signalee;
    private $ByGroup;
    private $note;

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
    public function __construct(array $activity)
    {
        $this->__hydrate($activity);
    }

    /**GETTER**/
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
    public function getNote()
    {
        return $this->note;
    }
    /**SETTER**/
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNote($note)
    {
        $this->note = $note;
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