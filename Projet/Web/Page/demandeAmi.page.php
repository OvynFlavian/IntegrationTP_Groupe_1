<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 19:25
 */
require "../Library/constante.lib.php";

initRequire();
require "../Library/Page/demandeAmi.lib.php";
require "../Entity/Amis.class.php";
require "../Manager/AmisManager.manager.php";
initRequireEntityManager();

startSession();
$isConnect = isConnect();
if(!$isConnect)
{
    session_destroy();
    header("Location:../");
}

$id = $_GET['membre'];
if ($id == $_SESSION['User']->getId()) {
    header("Location:../");

}
    if (isset($_POST['Accepter']) || isset($_POST['Refuser'])) {
        $message = gererDemande();
        if ($message == "Erreur") {
            header('Location: listeMembres.page.php');
        }
    }



$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande d'ami</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>

</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php") ?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Demande d'ami</h1>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            include("../Form/demandeAmi.form.php");
            ?>
        </article>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <h2 align="center">
            <?php
                if (isset($message)) {
                  echo $message;
                }
            ?>
            </h2>
        </article>
    </section>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
</html>