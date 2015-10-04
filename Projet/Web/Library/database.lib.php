<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:52
 */

/**
 * Fonction permettant la connexion à la base de donnée
 * @return PDO la base de donnée
 */
function connexionDb()
{
    $confDb = getConfigFile()['DATABASE'];

    $type = $confDb['type'];
    $host = $confDb['host'];
    $servername = "$type:host=$host";
    $username = $confDb['username'];
    $password = $confDb['password'];
    $dbname = $confDb['dbname'];

    $db = new PDO("$servername;dbname=$dbname", $username, $password);

    return $db;
}