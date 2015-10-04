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

    /**GETTER**/
    public function getId()
    {
        return $this->id;
    }
    public function getLibelle()
    {
        return $this->Libelle;
    }

    /**SETTER**/
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setLibelle($Libelle)
    {
        $this->Libelle = $Libelle;
    }

}