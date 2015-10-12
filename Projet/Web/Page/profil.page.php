<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 2/10/2015
 * Time: 16:48
 */

require "../Library/constante.lib.php";

initRequire();
initRequirePage("profil");
initRequireEntityManager();

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

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
</head>
<body>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">EveryDayIdea</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="../">Home</a></li>
                    <li class="active dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="../Page/profil.page.php">Profil
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../Page/profil.page.php?to=print">Afficher</a> </li>
                            <li><a href="../Page/profil.page.php?to=edit">Modifier</a> </li>
                        </ul>
                    </li>
                    <li><a href="../Page/connexion.page.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page de gestion de profil</h1>
        <p>Entrer les informations qui seront changée (les informations, n'ayant pas été changée, ne seront pas prises en compte)</p>
    </section>
    <section class="alert-dismissible">
        <?php foreach($errorFormulaire as $toPrint){?>
            <?php echo "<span class='alert-dismissable'>$toPrint</span>"?>
        <?php }?>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
                if(isset($_GET['to']) and $_GET['to'] == "edit")
                    include("../Form/profil.form.php");
                else
                    include ("../Form/profil_view.form.php");
            ?>
        </article>
    </section>
</section>
<footer class="panel-footer">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
</html>
<?php unset($_POST); ?>