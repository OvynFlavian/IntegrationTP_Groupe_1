<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
 function activationNewUser() {
     $code = $_GET['code'];
     $am = new ActivationManager(connexionDb());
     $ac = $am ->getActivationByCode($code);

     $noCode = false;
     if (empty($ac)) {
         $noCode = true;
     }

     if ($noCode) {
         echo "Votre code est incorrect, utilisez celui du mail prévu à cet effet !";
     } else {
         $am->deleteActivation($ac);
         echo "Vous êtes dorénavant activé, vous pouvez vous connecter normalement !";
     }

 }