<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:33
 */

require_once "./Library/constante.lib.php";

$listEntity = unserialize(LIST_ENTITY);
foreach($listEntity as $key => $value)
{
    require_once $value;
}