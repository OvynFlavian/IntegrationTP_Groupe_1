<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 24/11/2015
 * Time: 19:58
 */
    $gm = new GroupeManager(connexionDb());
    $groupe = $gm->getGroupeByLeader($_SESSION['User']);
    echo "<h1> L'ancienne description de votre groupe était : </h1>";
    echo "<div class='well well-lg'><h3>" . $groupe->getDescription() . " </h3></div>";
    echo "<h1> Entrez votre nouvelle description : </h1>";
?>
<form class='form-horizontal col-sm-12' name='modifier' action='groupe.page.php?to=voirGroupe&action=mod' method='post'>
<div class="form-group col-sm-12">
    <div class="col-sm-10">
        <?php
        echo "<span class='textareaModif'>";
        echo "<textarea  class='form-control' rows='5' id='descriptionGroupe' name='descriptionGroupe' required></textarea>";
        echo "<span>";
        ?>
    </div>
</div>
<div class="form-group col-sm-12">
    <div class=" col-sm-12">
        <button type="submit" class="btn btn-default" name="modifierDesc" id="modifierDesc">Modifier</button>
    </div>
</div>
</form>