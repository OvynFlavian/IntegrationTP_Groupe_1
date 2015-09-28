<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:26
 */
define("PATH_ENTITY", "../Entity/");
define("PATH_END_ENTITY", ".class.php");

/*On ajoute une entité dans le tableau pour pouvoir les récupérers automatiquement*/
define("LIST_ENTITY", serialize(array(
    "User" => PATH_ENTITY. "User". PATH_END_ENTITY,
)));