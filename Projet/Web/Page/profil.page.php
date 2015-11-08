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
$user = getSessionUser();

$configIni = getConfigFile();
$isValidForm = array();
$errorFormulaire = array();
if(isPostFormulaire())
{
    $isValidForm = isValidForm($user);
    if($isValidForm['RETURN'])
    {
        $class='success';
        $tab[0] = "Modification réalisée avec succes";
    }
    else
    {
        $class = 'danger';
        $tab = $isValidForm['ERROR'];
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
    <aside class="col-md-2" style="max-width: 200px;">
        <ul class="nav nav-pills nav-stacked">
            <li <?php if(empty($_GET)){echo 'class="active"';}?>><a href="profil.page.php">Afficher mon profil</a></li>
            <li <?php if(!empty($_GET)){echo 'class="active"';}?>><a href="?to=edit">Editer mon profil</a></li>
        </ul>
    </aside>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page de gestion de profil</h1>
        <?php
            if (!isset($_GET['to'])) {
                echo "<p>Visionnez les informations relatives à votre compte</p>";
            } else {
                echo "<p>Entrez les informations qui seront changées (les informations n'ayant pas été changées ne seront pas prises en compte)</p>";
            }
        ?>

    </section>
    <section class="row">
        <article class="col-sm-12">


            <?php
                if(isset($_GET['to']) and $_GET['to'] == "edit") {
                    editProfil();
                    if (isset($tab)) {
                        echo "<div class='col-sm-offset-3 col-sm-5'>";
                        echo "<div class='alert alert-$class' role='alert'>";
                        foreach ($tab as $elem) {
                            echo  "".$elem."<br>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }
                }

                else afficherProfil();

            ?>

        </article>
    </section>
</section>

<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com <span class="marge"> Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a></span>
</footer>
</body>
</html>
<?php unset($_POST); ?>