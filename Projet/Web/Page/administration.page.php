<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 15/10/2015
 * Time: 15:24
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";
initRequire();
initRequireEntityManager();
require "../Form/administration.form.php";
require "../Library/Page/administration.lib.php";
require "../Manager/User_ActivityManager.manager.php";

$configIni = getConfigFile();
startSession();
$user = getSessionUser();
$isConnect = isConnect();
if(!$isConnect or $user->getDroit()[0]->getLibelle() != "Administrateur")header("Location:../");


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

    <script src="../Script/administration.js"></script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
    <aside class="col-md-2" style="max-width: 250px;">
        <ul class="nav nav-pills nav-stacked" >
            <li <?php if((empty($_GET) || (isset($_GET['to']) && $_GET['to'] == 'profil'))) {echo 'class="active"';}?>><a href="administration.page.php">Voir les utilisateurs</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "viewConfig"){echo 'class="active"';}?>><a href="?to=viewConfig">Voir la configuration</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "editConfig"){echo 'class="active"';}?>><a href="?to=editConfig">Éditer la configuration</a></li>
        </ul>
    </aside>
</header>
<section class="container" id="administration">
    <section class="jumbotron">
        <h1>Page d'administration</h1>
        <?php
        if (!isset($_GET['to'])) {
            echo "<p>Affichage de la liste des membres présents sur votre site. Vous pouvez voir leur profil ou modifier leur grade. Il est aussi possible de leur envoyer un message.</p>";
        } else if (isset($_GET['to'])) {
            if ($_GET['to'] == 'viewConfig') {
                echo "<p>Affichage de la configuration de votre site.</p>";
            } else if ($_GET['to'] == 'editConfig') {
                echo "<p>Vous pouvez modifier la configuration de base de votre site.</p>";
            }
        }

        ?>
    </section>
    <section class="alert-dismissible">

    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
                if(isset($_GET['to']) and $_GET['to'] == "editConfig") {
                    $message = modifConfig();
                    administrationEditConfig();
                    if ($message != NULL) {
                        echo "<div class='col-sm-offset-4 col-sm-6'>";
                        echo "<span class='error'> $message </span>";
                        echo "</div>";
                    }

                }
                else if(isset($_GET['to']) and $_GET['to'] == "viewConfig") administrationViewConfig();

                else if(!isset($_GET['to'])) {
                    if (isset($_POST['voirProfil'])) {
                        $id = $_POST['idMembre'];
                        voirProfil($id);
                    } else if (isset($_POST['changerGrade'])) {
                        modifGrade();
                        echo "<h1 align='center'><span class='success'>Le grade de l'utilsateur a bien été changé !</span></h1>";
                        echo "<meta http-equiv='refresh' content='1; URL=administration.page.php'>";

                    }
                    else  {
                        afficherMembres();
                    }
                } else {
                    header("Location:../");
                }
            ?>
        </article>
    </section>
</section>

</body>
