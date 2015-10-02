<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 18:03
 */

function getConfigFile()
{
    return parse_ini_file("../config.ini", true);
}