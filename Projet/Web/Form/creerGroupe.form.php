<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 22/11/2015
 * Time: 23:18
 */
use \Entity\Activity as Activity;

    $uam = new User_ActivityManager(connexionDb());
    $actId = $uam->getActIdByUserId($_SESSION['User']);
    $act = new Activity(array(
        "id" => $actId[0]['id_activity']
    ));
    $am = new ActivityManager(connexionDb());
    $activity = $am->getActivityById($act->getId());
    echo "<form method='post' action='groupe.page.php?to=creerGroupe'>";
    echo "<h1> Création d'un groupe pour l'activité : ".$activity->getLibelle()."</h1><br><br>";
    echo "<input type='hidden'  name='idAct'  value='".$activity->getId()."'>"
?>
<div class="form-group col-sm-12">
    <label class="control-label col-sm-2" for="description">Description :</label>
    <div class="col-sm-10">
        <textarea class="form-control" rows="5" id="description" name="description" placeholder="Entrez ici les informations sur votre façon d'effectuer cette activité" required></textarea>
    </div>
</div>
<div class="form-group col-sm-12">
    <div class="col-sm-offset-2 col-sm-12">
        <button type="submit" class="btn btn-default" name="formulaireCreation" id="formulaireCréation">Créer le groupe</button>
    </div>
</div>
</form>