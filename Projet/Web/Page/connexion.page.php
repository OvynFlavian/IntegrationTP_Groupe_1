<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:34
 */
require "../Library/constante.lib.php";

initRequire();
initRequirePage("connexion");
initRequireEntityManager();

startSession();
$isConnect = isConnect();
$tabRetour = array();
if($isConnect)
{
    session_destroy();
    header("Location:../");
}
if(isPostFormulaire())
{
    $tabRetour = doConnect();
    if($tabRetour['Retour'])header("Location:../");
}
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <script type="text/javascript">
        <?php
            include("../Script/connexion.js");
        ?>
    </script>
</head>
<body>
<header>
    <!--
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">EveryDayIdea</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="../">Home</a></li>
                    <li class="active"><a href="../Page/connexion.page.php">Connexion</a></li>
                    <li><a href="../Page/inscription.page.php">Inscription</a></li>
                </ul>
            </div>
        </div>
    </nav>
    -->
    <?php include("../Menu/menuGeneral.lib.php") ?>
</header>
    <section class="container">
        <section class="jumbotron">
            <h1>Page Connexion</h1>
        </section>
        <section class="row">
            <article class="col-sm-12">
                <?php
                include("../Form/connexion.form.php");
                ?>
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
</body>
</html>