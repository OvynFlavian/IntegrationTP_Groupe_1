<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 20:13
 */

function Premium() {
    $udm = new User_DroitManager(connexionDb());
    $udm->modifDroit($_SESSION['User']->getId(), 3);
    $um = new UserManager(connexionDb());
    $user = $um->getUserById($_SESSION['User']->getId());
    $_SESSION['User'] = $user;

}