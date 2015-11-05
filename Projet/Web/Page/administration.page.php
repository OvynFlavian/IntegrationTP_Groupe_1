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

$configIni = getConfigFile();
startSession();
$user = getSessionUser();
$isConnect = isConnect();
if(!$isConnect or $user->getDroit()[0]->getLibelle() != "Administrateur")header("Location:../");
$pdo = connexionDb();
$um = new UserManager($pdo);
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
    <aside class="col-md-2" style="max-width: 200px;">
        <ul class="nav nav-pills nav-stacked">
            <li <?php if(empty($_GET)){echo 'class="active"';}?>><a href="administration.page.php">Accueil admin</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "editUser"){echo 'class="active"';}?>><a href="?to=editUser">Voir les utilisateurs</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "viewConfig"){echo 'class="active"';}?>><a href="?to=viewConfig">Voir le fichier de config</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "editConfig"){echo 'class="active"';}?>><a href="?to=editConfig">Édition fichier de config</a></li>
        </ul>
    </aside>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page d'administration</h1>
        <p></p>
    </section>
    <section class="alert-dismissible">

    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
                if(isset($_GET['to']) and $_GET['to'] == "editConfig") administrationEditConfig();
                else if(isset($_GET['to']) and $_GET['to'] == "viewConfig") administrationViewConfig();
                else if(isset($_GET['to']) and $_GET['to'] == "editUser") administrationEditUser($um);
            ?>
        </article>
    </section>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
