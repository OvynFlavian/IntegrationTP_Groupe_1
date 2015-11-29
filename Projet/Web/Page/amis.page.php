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
require "../Manager/GroupeManager.manager.php";
require "../Manager/User_GroupeManager.manager.php";
require "../Manager/Groupe_MessageManager.manager.php";
require "../Entity/Groupe.class.php";
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
    <link rel="icon" type="image/png" href="../Images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>


    <link rel="stylesheet" type="text/css" href="../personalisation.css">
</head>
<body>
<section class="container" id="administration">
    <header>
        <?php include("../Menu/menuGeneral.lib.php") ?>
    </header>
    <div class="col-md-2 clearfix" id="sub-menu-left">
        <nav class="sidebar-nav">
            <ul class="nav sidebar-nav sidebar-collapse">
                <li <?php if(empty($_GET)){echo 'class="active"';}?>><a href="amis.page.php">Liste de mes amis</a></li>
                <li <?php if(!empty($_GET) and $_GET['to'] == "friendList"){echo 'class="active"';}?>><a href="?to=friendList">Voir mes demandes</a></li>
            </ul>
        </nav>
    </div>
    <section class="col-lg-8 jumbotron">
        <h1> <img class="jumbotitre" src="../Images/bannieres/amis.png" alt="logo" /></h1>
        <p class="jumbotexte"> Ici, vous pouvez voir vos demandes en cours, les demandes vous étant envoyées ainsi que la liste de vos amis</p>
    </section>
    <section class="row col-lg-12">
        <?php
        if(empty($_GET)) {
            $id = gererPost();
            if (isset($_POST['supprimerAmi'.$id.''])) {
                gererSuppression($id);
            } else if (isset($_POST['AccepterSup']) || isset($_POST['RefuserSup'])) {
                gererReponseSup();
            } else {
                listeAmi();
            }
        }
        else if(isset($_GET['to']) and $_GET['to'] == "friendList") {
            demande();
        }
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
    <footer class="footer navbar-fixed-bottom">
        <div class="col-xs-4">&copy; everydayidea.be</div>
        <div class="col-xs-4" style="text-align: center"> Contactez <a href="mailto:postmaster@everydayidea.be">l'administrateur</a></div>
        <div class="col-xs-4"></div>
    </footer>
</section>

</body>
</html>