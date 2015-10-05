<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 17:15
 */

/**
 * Fichier regroupant l'ensemble des fonctions de gestion de la variable global POST
 */

/**
 * Fonction permettant de savoir si l'on a appuyer sur un bouton de validation de formulaire.
 * @return bool
 */
function isPostFormulaire()
{
    return isset($_POST['formulaire']);
}