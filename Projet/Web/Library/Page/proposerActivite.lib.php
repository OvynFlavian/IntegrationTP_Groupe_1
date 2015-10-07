<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:30
 */

function proposerActivite($cat) {
    if ($_GET['categorie'] == 'visite' || $_GET['categorie'] == 'film' ) {

        $tabActivite = array(
            "visite" => array("Musée de la Sambre", "Zoo d'Anvers", "Pairy Daisa", "Place de Bruxelles", "Atomium"),
            "film" => array("Gladiator", "Mad max", "Au nom de la rose", "Ghostbusters", "Le père Noel est une ordure"),
        );
        $s = 0;
        $c = 4;
        $idx=mt_rand($s, $c);
        echo "<p>".$tabActivite[$cat][$idx]."</p> \n";

        include "../Form/proposerActivite.form.php" ;
    }
}

function gererReponse($cat) {
    if (isset($_POST['Accepter'])) {
        header('Location: choisirCategorie.page.php');

    } else if (isset($_POST['Refuser'])) {
        header("Location: proposerActivite.page.php?categorie=$cat");
    }
}