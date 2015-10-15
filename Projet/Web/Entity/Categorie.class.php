<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 29/09/2015
 * Time: 19:44
 */
namespace Entity;

/**
 * Class Categorie
 * Entité de la base de donnée définissant une catégorie d'activité de l'application et du site.
 */
class Categorie {
    private $id;
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
        return $this->libelle;
    }

    /**SETTER**/
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

}