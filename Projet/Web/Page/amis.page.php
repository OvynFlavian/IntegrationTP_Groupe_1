<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/11/2015
 * Time: 19:21
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
require "../Library/Page/amis.lib.php";
require "../Entity/Amis.class.php";
require "../Manager/AmisManager.manager.php";
require "../Manager/User_ActivityManager.manager.php";
initRequireEntityManager();

startSession();
$isConnect = isConnect();
if(!$isConnect)
{
    session_destroy();
    header("Location:../");
}
gererValidation();
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste de mes amis</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php") ?>
    <aside class="col-md-2" style="max-width: 200px;">
        <ul class="nav nav-pills nav-stacked">
            <li <?php if(empty($_GET)){echo 'class="active"';}?>><a href="amis.page.php">Liste de mes amis</a></li>
            <li <?php if(!empty($_GET) and $_GET['to'] == "friendList"){echo 'class="active"';}?>><a href="?to=friendList">Voir mes demandes</a></li>

        </ul>
    </aside>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Gérer mes amis</h1>
        <p> Ici, vous pouvez voir vos demandes en cours, les demandes vous étant envoyées ainsi que la liste de vos amis</p>
    </section>
    <section class="row">
        <?php
        if(empty($_GET)) listeAmi();
        else if(isset($_GET['to']) and $_GET['to'] == "friendList") demande();
        else if (isset($_GET['to']) and $_GET['to'] == "modifAct") {
            if (verifIdAct()) {
                if (isset($_GET['func']) && $_GET['func']=="replace") {
                    modifActivite();
                }
                modifAct();
                gererReponse();
            } else {
                header("Location:../");
            }


        }
        ?>
    </section>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
</html>