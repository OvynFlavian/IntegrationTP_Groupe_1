<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
/**
 * Fonction servant à activer un nouvel utilisateur à l'aide de son code d'activation fourni dans l'url.
 * Si le code n'existe pas, il envoie un message d'erreur, sinon il active le membre et le redirige vers la page de connexion.
 */
 function activationNewUser() {
     $code = $_GET['code'];
     $am = new ActivationManager(connexionDb());
     $ac = $am ->getActivationByCode($code);

     $noCode = false;
     if ($ac->getCode() == NULL) {
         $noCode = true;
     }

     if ($noCode) {
         echo "Votre code est incorrect, utilisez celui du mail prévu à cet effet !";
     } else {
         $am->deleteActivation($ac);
         echo "Vous êtes dorénavant activé, vous pouvez vous connecter normalement !";
         echo "<meta http-equiv='refresh' content='2; URL=connexion.page.php'>";
     }

 }