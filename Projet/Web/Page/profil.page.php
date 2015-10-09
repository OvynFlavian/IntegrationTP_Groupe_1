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
if(isPostFormulaire())
{
    if(isValidForm()['RETURN'])
    {
        modifyProfil($user);
    }
    else
    {
        $errorFormulaire = isValidForm()['ERROR'];
    }
    unset($_POST['formulaire']);
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
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
                    <li><a href="../Page/connexion.page.php">Déconnexion</a></li>
                    <li class="active"><a href="../Page/profil.page.php">Profil</a></li>
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
    <section class="row">
        <article class="col-sm-12">
            <?php include("../Form/profil.form.php");?>
        </article>
    </section>
    <?php if(isset($tabRetour['Error'])){?>
        <section class="alert-dismissible">
            <p><?php echo $tabRetour['Error']?></p>
        </section>
    <?php }?>
</section>
<footer class="panel-footer">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
<script>
    var jsTab = <?php echo '["'. implode('", "', isset($errorFormulaire)? $errorFormulaire : array()). '"]'?>;
    if(jsTab.length > 1)
    {
        alert(jsTab.join("\n"));
    }
</script>
</body>
</html>