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

define("PATH_ENTITY", "./Entity/");
define("PATH_END_ENTITY", ".class.php");
define("PATH_PAGE", "./Page/");
define("PATH_END_PAGE", ".page.php");

/*On ajoute une entité dans le tableau pour pouvoir les récupérers automatiquement*/
define("LIST_ENTITY", serialize(array(
    "User" => PATH_ENTITY. "User". PATH_END_ENTITY,
    "Message" => PATH_ENTITY. "Message". PATH_END_ENTITY,
    "Droit" => PATH_ENTITY. "Droit". PATH_END_ENTITY,
    "Categorie" => PATH_ENTITY. "Categorie". PATH_END_ENTITY,
    "Activity" => PATH_ENTITY. "Activity". PATH_END_ENTITY,
    "Activation" => PATH_ENTITY. "Activation". PATH_END_ENTITY,
)));

define("LIST_PAGE", serialize(array(
    "Home" => PATH_PAGE. "home". PATH_END_PAGE,
)));
