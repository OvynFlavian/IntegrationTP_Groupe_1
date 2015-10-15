<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 15/10/2015
 * Time: 15:24
 */
require "../Library/constante.lib.php";
initRequire();
initRequireEntityManager();

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
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
    <aside class="col-md-1">
        <ul class="nav nav-pills nav-stacked">
            <li <?php if(empty($_GET)){echo 'class="active"';}?>><a href="administration.page.php">Acceuil admin</a></li>
            <li <?php if(!empty($_GET)){echo 'class="active"';}?>><a href="?to=editConfig">Édition fichier de config</a></li>
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
            <?php include("../Form/administrationConfig.form.php");?>
        </article>
    </section>
</section>
<footer class="panel-footer">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
