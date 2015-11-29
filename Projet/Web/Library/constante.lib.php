<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:26
 */

/**
 * Fichier regroupant l'ensemble des constantes globales du site.
 */

define("PATH_ENTITY", "../Entity/");
define("PATH_END_ENTITY", ".class.php");

define("PATH_LIBRARY", "../Library/");
define("PATH_END_LIBRARY", ".lib.php");

define("PATH_MANAGER", "../Manager/");
define("PATH_END_MANAGER", "Manager.manager.php");

/*On ajoute une entité dans le tableau pour pouvoir les récupérers automatiquement*/
define("LIST_ENTITY", serialize(array(
    "User" => PATH_ENTITY. "User". PATH_END_ENTITY,
    "Message" => PATH_ENTITY. "Message". PATH_END_ENTITY,
    "Droit" => PATH_ENTITY. "Droit". PATH_END_ENTITY,
    "Categorie" => PATH_ENTITY. "Categorie". PATH_END_ENTITY,
    "Activity" => PATH_ENTITY. "Activity". PATH_END_ENTITY,
    "Activation" => PATH_ENTITY. "Activation". PATH_END_ENTITY,
)));

define("LIST_MANAGER", serialize(array(
    "User" => PATH_MANAGER. "User". PATH_END_MANAGER,
    "Droit" => PATH_MANAGER. "Droit". PATH_END_MANAGER,
    "Categorie" => PATH_MANAGER. "Categorie". PATH_END_MANAGER,
    "Activity" => PATH_MANAGER. "Activity". PATH_END_MANAGER,
    "Activation" => PATH_MANAGER. "Activation". PATH_END_MANAGER,
    "Categorie_Activity" => PATH_MANAGER. "Categorie_Activity". PATH_END_MANAGER,
)));

define("LIST_LIBRARY", serialize(array(
    "config" => PATH_LIBRARY. "config". PATH_END_LIBRARY,
    "database" => PATH_LIBRARY. "database". PATH_END_LIBRARY,
    "get" => PATH_LIBRARY. "get". PATH_END_LIBRARY,
    "post" => PATH_LIBRARY. "post". PATH_END_LIBRARY,
    "session" => PATH_LIBRARY. "session". PATH_END_LIBRARY,
)));

define("MENU_ANONYME", "/Library/Menu/menuAnonyme.lib.php");
define("MENU_CONNECTER", "/Library/Menu/menuConnecter.lib.php");
define("MENU_ANONYME_PAGE", "/Library/Menu/menuAnonymePage.lib.php");
define("MENU_CONNECTER_PAGE", "/Library/Menu/menuConnecterPage.lib.php");

/**
 * Fonction permettant de générer tous les require d'une page automatiquement.
 */
function initRequire()
{
    $listLibrary = unserialize(LIST_LIBRARY);

    foreach($listLibrary as $key => $value)
    {
        require $value;
    }
}

/**
 * Fonction générant tous les require d'une page en particulier.
 * @param $namePage : nom de la page concerné.
 */
function initRequirePage($namePage)
{
    require "../Library/Page/$namePage.lib.php";
}

/**
 * Fonction permettant de générer tous les require d'entité sur une page.
 */
function initRequireEntityManager()
{
    $listEntity = unserialize(LIST_ENTITY);

    foreach($listEntity as $key => $value)
    {
        require $value;
        if($key != "Message")require PATH_MANAGER. $key. PATH_END_MANAGER;
    }
}
