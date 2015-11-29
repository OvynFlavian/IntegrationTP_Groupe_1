<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 16:06
 */
/**
 * Fonction servant à vérifier tous les caractères d'un string.
 * @param $champ : le champ texte que l'on veut analyser.
 * @return bool : true si il n'y a pas de caractères indésirables dedans, false si il y en a.
 */
    function champsEmailValable($champ) {
     if(preg_match('#^[a-zA-Z0-9@._]*$#', $champ)) {
           return true;
     }
      else {
         return false;
     }
    }

/**
 * Fonction servant à vérifier l'existence d'un membre à l'aide de l'ID contenu dans l'url.
 * @return bool : true si il existe, false si il n'existe pas.
 */
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

/**
 * Fonction vérifiant tous les caractère d'un champ de login dans un formulaire.
 * @param $champ : le champs de login que l'on veut analyse.
 * @return bool : true si le champ ne possède pas de caractères indésirables, false si il en contient.
 */
    function champsLoginValable($champ) {
     if(preg_match('#^[a-zA-Z0-9 \ éàèîêâô! ]*$#', $champ)) {
          return true;
     }
     else {
         return false;
     }
    }

/**
 * Fonction vérifiant tous les caractères d'un champ de mot de passe d'un formulaire.
 * @param $champ : le champ mot de passe du formulaire.
 * @return bool : true si il ne possède pas de caractères indésirables, false si il en contient.
 */
    function champsMdpValable($champ) {
     if(preg_match('#^[a-zA-Z0-9 œ \ éàèîêâô!? ]*$#', $champ)) {
           return true;
        }
     else {
          return false;
     }
    }

/**
 * Fonction vérifiant tous les caractères d'un champ texte d'un formulaire.
 * @param $champ : le champ texte d'un formulaire.
 * @return bool : true si il ne contient pas de caractères indésirables, false si il en contient.
 */
    function champsTexteValable($champ) {
        if(preg_match('#^[a-zA-Z0-9 \'éàèîêâô!_/*-+ç&\[\]?$-\|\(\)\r\n]*$#', $champ)) {
          return true;
      }
     else {
         return false;
      }
    }

/**
 * Fonction comparant la date du jour et la date donnée en paramètre.
 * @param $date : date que l'on souhaite comparer avec celle d'aujourd'hui.
 * @param $delai : délai que l'on souhaite vérifier entre les deux dates.
 * @return bool : true si la date du jour est plus grande que la date+le délai, false si elle est plus petite.
 */
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

/**
 * Fonction comparant la date du jour et une date donnée avec un délai en heure.
 * @param $date : la date que l'on souhaite comparer.
 * @param $delai : le délai en heure souhaité.
 * @return bool : true si la date du jour est plus grande que la date+délai, false si elle est plus petite.
 */
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

/**
 * Fonction servant à vérifier si l'utilisateur n'a pas proposé d'activité depuis plus de 7 jours.
 * @return bool : true si l'utilisateur peut poster une activité, false si il ne peut pas.
 */
    function dateLastIdea() {
        if (comparerDate($_SESSION['User']->getDateLastIdea(), 7)) {
            return true;
        } else {
            return false;
        }


    }

/**
 * Fonction servant à générer un code aléatoire servant au mot de passe oublié ou à l'activation.
 * @return string : le code généré.
 */
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

/**
 * Fonction servant à afficher le formulaire fourni par Paypal servant à faire un don.
 */
    function buttonPaypal() {
        ?>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="CK7EUW9464MLA">
            <input style="margin-top :4%" type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
            <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
        </form>

        <?php
    }

/**
 * Fonction servant à charger une image et la mettre dans un dossier du serveur.
 * @param $repertoire : le répertoire d'arrivée de l'image.
 * @param $nom : le nom de l'image.
 */
function uploadImage($repertoire, $nom) {
    $repertoire = $repertoire.'/'; // dossier où sera déplacé le fichier
    $photo = $_FILES['image']['tmp_name'];
    if( !is_uploaded_file($photo) ) {
        exit("Le fichier est introuvable <br>");
    }
    // on vérifie maintenant l'extension
    $typePhoto = $_FILES['image']['type'];
    if( !strstr($typePhoto, 'jpg') && !strstr($typePhoto, 'jpeg')) {
        exit("Le fichier n'est pas une image ou n'est pas en jpg (seul format admis) <br>");
    }
    // on copie le fichier dans le dossier de destination
    $nomPhoto = $nom.".jpg";



    $donnees=getimagesize($photo);
    $nouvelleLargeur = 200;
    $reduction = ( ($nouvelleLargeur * 100) / $donnees[0]);
    $nouvelleHauteur = ( ($donnees[1] * $reduction) / 100);
    $image = imagecreatefromjpeg($photo);
    $image_mini = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur); //création image finale
    imagecopyresampled($image_mini, $image, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $donnees[0], $donnees[1]);//copie avec redimensionnement
    imagejpeg ($image_mini, $repertoire.$nomPhoto);
}

?>


