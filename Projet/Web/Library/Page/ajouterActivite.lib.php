<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 18/10/2015
 * Time: 17:16
 */
use \Entity\Activity as Activity;
use \Entity\Categorie as Categorie;
use \Entity\User as User;

function ajouterActivite() {
        $cat = $_POST['categorie'];
        $act = $_POST['activite'];
        $desc = $_POST['description'];

        $cm = new CategorieManager(connexionDb());
        $am = new ActivityManager(connexionDb());

        $categorie = $cm->getCategorieByLibelle($cat);

        $activityVerif = $am->getActivityByLibelle($act);

        if (strtolower($activityVerif->getLibelle()) == strtolower($act)) {
            $tabRetour['Error'] = "Cette activité existe déjà, ajoutez-en une autre !";
        } else {
            if (strlen($act) >= 5 && strlen($act) <= 100) {
                if (champsTexteValable($desc)) {
                    $desc = nl2br($desc);
                    $activityToAdd = new Activity(array(
                        "Libelle" => $act,
                        "description" => $desc,
                    ));
                    $am->addActivity($activityToAdd);

                    $activityToRecup = $am->getActivityByLibelle($act);
                    include "../Manager/Categorie_ActivityManager.manager.php";
                    $typePhoto = $_FILES['image']['type'];
                    if( !strstr($typePhoto, 'jpg') && !strstr($typePhoto, 'jpeg')) {
                        $tabRetour['Error'] = "Votre image n'est pas .jpg ou .jpeg !";
                    } else if  ($_FILES['ImageNews']['size'] >= 2097152) {
                        $tabRetour['Error'] = "Votre image est trop lourde !";

                    } else {
                        if ($_FILES['image']['tmp_name'] != null) {

                            uploadImage('../Images/activite', $activityToRecup->getId());

                            $cam = new Categorie_ActivityManager(connexionDb());
                            $um = new UserManager(connexionDb());
                            $um->updateUserLastIdea($_SESSION['User']);
                            $cam->addToTable($activityToRecup, $categorie);
                            $tabRetour['Ok'] = "Votre activité a bien été ajoutée au contenu du site, merci de votre participation !";
                        } else {
                            $tabRetour['Error'] = "Pas d'image !";
                        }
                    }
                } else {
                    $tabRetour['Error'] = "Votre description contient des caractères indésirables !";
                }
            } else {
                $tabRetour['Error'] = "Votre titre d'activité n'a pas une taille correcte !";
            }


        }
        return $tabRetour;



}