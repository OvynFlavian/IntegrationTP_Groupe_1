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
            $activityToAdd = new Activity(array(
                "Libelle" => $act,
                "description" => $desc,
            ));
            $am->addActivity($activityToAdd);

            $activityToRecup = $am->getActivityByLibelle($act);
            include "../Manager/Categorie_ActivityManager.manager.php";
            $cam = new Categorie_ActivityManager(connexionDb());
            $um = new UserManager(connexionDb());
            $um->updateUserLastIdea($_SESSION['User']);
            $cam->addToTable($activityToRecup, $categorie);
            $tabRetour['Ok'] = "Votre activité a bien été ajoutée au contenu du site, merci de votre participation !";


        }
        return $tabRetour;



}