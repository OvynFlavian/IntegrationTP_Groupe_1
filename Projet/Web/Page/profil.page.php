<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 16:48
 */

require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequirePage("profil");
initRequireEntityManager();

require "../Form/profil.form.php";

startSession();
$isConnect = isConnect();
if(!$isConnect)header("Location:../index.php");

$um = new UserManager(connexionDb());
$user = $um->getUserById(getSessionUser()->getId());

$configIni = getConfigFile();
$isValidForm = array();
$errorFormulaire = array();
if(isPostFormulaire())
{
    $isValidForm = isValidForm();
    if($isValidForm['RETURN'])
    {
        modifyProfil($user);
        $errorFormulaire['SUCCES'] = "Modification réalisée avec succes";
    }
    else
    {
        $errorFormulaire = $isValidForm['ERROR'];
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
    <aside class="col-md-1">
        <ul class="nav nav-pills nav-stacked">
            <li <?php if(empty($_GET)){echo 'class="active"';}?>><a href="profil.page.php">View profil</a></li>
            <li <?php if(!empty($_GET)){echo 'class="active"';}?>><a href="?to=edit">Edit profil</a></li>
        </ul>
    </aside>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page de gestion de profil</h1>
        <p>Entrez les informations qui seront changées (les informations n'ayant pas été changées ne seront pas prises en compte)</p>
    </section>
    <section class="alert-dismissible">
        <?php foreach($errorFormulaire as $toPrint){?>
            <?php echo "<span class='alert-dismissable'>$toPrint</span>"?>
        <?php }?>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
                if(isset($_GET['to']) and $_GET['to'] == "edit")editProfil($errorFormulaire);
                else if(isset($_GET['to']) and $_GET['to'] == "viewProfilAdmin")
                {
                    viewProfilAdmin($um);
                }
                else viewProfil();

            ?>
        </article>
    </section>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
</html>
<?php unset($_POST); ?>