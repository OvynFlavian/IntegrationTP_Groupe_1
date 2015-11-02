<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 18/10/2015
 * Time: 17:16
 */
use \Entity\Activity as Activity;
use \Entity\Categorie as Categorie;

function ajouterActivite() {
        $cat = $_POST['categorie'];
        $act = $_POST['activite'];

        $cm = new CategorieManager(connexionDb());
        $am = new ActivityManager(connexionDb());

        $categorie = $cm->getCategorieByLibelle($cat);

        $activityVerif = $am->getActivityByLibelle($act);

        if ($activityVerif->getLibelle() == $act) {
            $tabRetour['Error'] = "Cette activité existe déjà, ajoutez-en une autre !";
        } else {
            $activityToAdd = new Activity(array(
                "Libelle" => $act
            ));
            $am->addActivity($activityToAdd);

            $activityToRecup = $am->getActivityByLibelle($act);
            include "../Manager/Categorie_ActivityManager.manager.php";
            $cam = new Categorie_ActivityManager(connexionDb());
            $cam->addToTable($activityToRecup, $categorie);
            $tabRetour['Ok'] = "Votre activité a bien été ajoutée au contenu du site, merci de votre participation !";


        }
        return $tabRetour;



}