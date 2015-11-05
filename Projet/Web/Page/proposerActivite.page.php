<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 07-10-15
 * Time: 20:30
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequirePage("proposerActivite");
initRequireEntityManager();
require "../Manager/User_ActivityManager.manager.php";
require "../Manager/Categorie_ActivityManager.manager.php";
startSession();
$isConnect = isConnect();
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposer une activité</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
    <aside class="col-md-2" style="max-width: 200px;">
        <ul class="nav nav-pills nav-stacked">
            <?php
            if (isset($_GET['categorie'])) {
                $cat = $_GET['categorie'];
                echo "<li ";
                if(!isset($_GET['choix'])){
                    echo "class='active'";
                    }
                echo "><a href='proposerActivite.page.php?categorie=$cat''>Génération aléatoire</a></li>";
                if (isConnect()) {
                    echo "<li ";
                    if (isset($_GET['choix']) and $_GET['choix'] == "personnel") {
                        echo "class='active'";
                    }
                    echo "><a href='?categorie=$cat&choix=personnel'>Choix dans la liste</a></li>";
                } else {
                    echo "<li><a href='connexion.page.php'> Plus d'options ? </a></li> ";
                }
            }
            ?>

        </ul>
    </aside>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page des activités</h1>
        <p>Voici l'activité qui vous est proposée par EveryDayIdea :</p>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            if (isset($_GET['categorie'])) {
                $cat = $_GET['categorie'];
                if (verifCat($cat)) {
                    if (isset($_GET['choix']) && ($_GET['choix'] == 'personnel') && isConnect()) {
                        require "../Form/choixPersonnel.form.php";
                        $tab = rechercheActivite();
                        afficherActivites($tab, $cat);
                    } else {
                        if (isset($_GET['activite']) && !verifIdAct()) {
                            header("Location:../");
                        } else {
                            $idActivite = proposerActivite($cat);
                            gererReponse($cat, $idActivite);
                            if (isset($_GET['to']) && $_GET['to'] == 'modif' && isConnect() && isset($_GET['activite'])) {
                                modifActivite();
                            } else if ((isset($_GET['to']) && !isConnect()) || (isset($_GET['to']) && $_GET['to'] != 'modif' && isConnect())) {
                                header('Location: ../');
                            }
                        }
                    }
                } else {
                    echo "<h1>Votre catégorie est fausse, cliquez sur un des boutons proposés !</h1>";
                    echo "<meta http-equiv='refresh' content='1; URL=choisirCategorie.page.php'>";
                }
            } else {
                echo "<h1>Vous n'avez pas de catégorie !</h1>";
                echo "<meta http-equiv='refresh' content='1; URL=choisirCategorie.page.php'>";

            }

            ?>
        </article>
    </section>
</section>
<div class="footer-container">
    <div class="row">
        <footer class="footer panel-footer navbar-fixed-bottom">
            &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a></span>
        </footer>
    </div>
</div>
</body>
</html>