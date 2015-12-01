<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 18/10/2015
 * Time: 10:59
 */
/**
 * Fonction renvoyant le nom de la page actuelle.
 * @return string : le nom de la page.
 */
function getCurrentPage()
{
    $runningFile = $_SERVER['PHP_SELF'];
    $url = explode("/", $runningFile);
    $pages = explode(".", $url[2]);
    $page = $pages[0];

    return $page;
}