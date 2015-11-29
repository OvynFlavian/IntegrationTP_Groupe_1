<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:15
 */


function afficherCategorie() {

      $cm = new CategorieManager(connexionDb());
            $i = 0;
            $tab = $cm->getAllCategorie();
            foreach ($tab as $elem) {
                $i++;
                $cat = $elem->getLibelle();
                if($i%2 != 0)
                {
                    echo "<article id='cat' class='col-sm-4' style='text-align: right'>";
                }
                else
                {
                    echo "<article id='cat' class='col-sm-4' style='text-align: left'>";
                }
                echo "<a href='proposerActivite.page.php?categorie=$cat' title='$cat'><img height='150px' width='150px' src='../Images/categories/$cat.jpg' alt='$cat'/></a>";
                echo "</article>";
            }




}