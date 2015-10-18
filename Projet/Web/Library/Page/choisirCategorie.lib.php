<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:15
 */


function afficherCategorie() {

      $cm = new CategorieManager(connexionDb());
            $tab = $cm->getAllCategorie();
            foreach ($tab as $elem) {
                $cat = $elem->getLibelle();
                echo "<article class='col-sm-6'>";
                echo "<a href='proposerActivite.page.php?categorie=$cat' title='$cat'><img src='../Images/$cat.jpg' alt='$cat'/></a>";
                echo "</article>";
            }




}