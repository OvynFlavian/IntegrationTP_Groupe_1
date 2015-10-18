<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 16:06
 */
    function champsEmailValable($champ) {
     if(preg_match('#^[a-zA-Z0-9@._]*$#', $champ)) {
           return true;
     }
      else {
         return false;
     }
    }

    function champsLoginValable($champ) {
     if(preg_match('#^[a-zA-Z0-9 \ éàèîêâô! ]*$#', $champ)) {
          return true;
     }
     else {
         return false;
     }
    }

    function champsMdpValable($champ) {
     if(preg_match('#^[a-zA-Z0-9 \ éàèîêâô!? ]*$#', $champ)) {
           return true;
        }
     else {
          return false;
     }
    }

    function comparerDate($date, $delai) {
    if ($delai == 0) {
        return false;
    } else {
        $datejour = date('Y-m-d H:i:s');
        $datejour = strtotime($datejour);
        $date = strtotime(date("Y-m-d", strtotime($date))."+$delai day");
        if ($datejour > $date) {
            return true;
        } else {
            return false;
        }
    }

}
    function genererCode() {
        $characts    = 'abcdefghijklmnopqrstuvwxyz';
        $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characts   .= '1234567890';
        $code_aleatoire      = '';

        for($i=0;$i < 6;$i++)    //10 est le nombre de caractères
        {
            $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
        }
        return $code_aleatoire;
    }

?>


