<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:52
 */

function connexionDb()
{
    $servername = "mysql:host=localhost";
    $username = "root";
    $password = "";
    $dbname = "dbname=projetIntegration";

    $db = new PDO("$servername;$dbname", $username, $password);

    return $db;
}