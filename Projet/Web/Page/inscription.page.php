<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:35
 */
    require "../Library/constante.lib.php";
    require "../Library/Fonctions/Fonctions.php";
    initRequire();
    initRequireEntityManager();
    initRequirePage("inscription");

    $configIni = getConfigFile();
    startSession();
    connexionDb();
    $isConnect = isConnect();
    if($isConnect)header("Location:../");
    if(isPostFormulaire() && isValidBis()['Retour']) {
        addDB();
        $tabRetour['Error'][] = "Votre inscription est effective";

    } else if (isPostFormulaire() and !isValidBis()['Retour']) {
        foreach (isValidBis()['Error'] as $elem) {
            $tabRetour['Error'][] = $elem;
        }
    }
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="../vendor/twitter/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../Style/general.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
    <script src="dist/js/bootstrap-submenu.min.js" defer></script>
    <script type="text/javascript">
        <?php
            include("../Script/inscription.js");
        ?>
    </script>
</head>
<body>
<header>
    <?php include("../Menu/menuGeneral.lib.php");?>
</header>
<section class="container">
    <section class="jumbotron">
        <h1>Page d'inscription</h1>
        <p>Rentrez vos données personnelles afin de recevoir un code d'activation par mail !</p>
    </section>
    <section class="row">
        <article class="col-sm-12">
            <?php
            include("../Form/inscription.form.php");
            ?>
        </article>
    </section>
    <?php if(isset($tabRetour['Error'])){?>
        <section class="alert-dismissible">
            <?php foreach($tabRetour['Error'] as $error){?>
                <p><?php echo $error?></p>
            <?php }?>
        </section>
    <?php }?>
</section>
<footer class="footer panel-footer navbar-fixed-bottom">
    &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
</footer>
</body>
</html>