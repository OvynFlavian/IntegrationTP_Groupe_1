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

    function membreExistant() {
        $id = $_GET['membre'];
        $um = new UserManager(connexionDb());
        $user = $um->getUserById($id);
        if ($user->getUserName() == NULL) {
            return false;
        } else {
            return true;
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
    function champsTexteValable($champ) {
        if(preg_match('#^[a-zA-Z0-9 \'éàèîêâô!_/*-+ç&\[\]?$-\|\(\)\r\n]*$#', $champ)) {
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

    function comparerHeure($date, $delai) {
        if ($delai == 0) {
            return false;
        } else {
            $datejour = date('Y-m-d H:i:s');
            $datejour = strtotime($datejour);
            $date = strtotime(date("Y-m-d H:i:s",strtotime($date))."+$delai hour");
            if ($datejour > $date) {
                return true;
            } else {
                return false;
            }
        }
    }
    function dateLastIdea() {
        if (comparerDate($_SESSION['User']->getDateLastIdea(), 7)) {
            return true;
        } else {
            return false;
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

    function buttonPaypal() {
        ?>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="CK7EUW9464MLA">
            <p class="navbar-text">Devenir Premium : </p><input style="margin-top :4%" type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
            <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
        </form>

        <?php
    }

?>


