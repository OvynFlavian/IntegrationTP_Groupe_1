<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 1/10/2015
 * Time: 14:35
 */
    require "../Library/constante.lib.php";
    initRequire();
    initRequirePage("inscription");

    require "../Entity/User.class.php";
    require "../Manager/UserManager.manager.php";

    require "../Entity/Activation.class.php";
    require "../Manager/ActivationManager.manager.php";

    startSession();
    connexionDb();
    $isConnect = isConnect();
    if($isConnect)header("Location:../");
    if(isPostFormulaire() && isValidBis()['Retour']) {

        addDB();
    } else if (isPostFormulaire() and !isValidBis()['Retour']) {

        foreach (isValidBis()['Error'] as $elem) {
            echo $elem;
        }
    }
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="../Style/presentationCss.css">
    <!--<link rel="script" type="text/javascript" href="../Script/inscription.js">-->
    <script type="text/javascript">
        <?php
            include("../Script/inscription.js");
        ?>
    </script>
</head>
<body>
    <header>
        <?php
            if(!$isConnect)include("..". MENU_ANONYME_PAGE);
            else include("..". MENU_CONNECTER_PAGE);
        ?>
    </header>
    <section id="section_corps">
        <div id="div_left">
            &nbsp;
        </div>

        <div id="div_center">
            <h1>Page d'inscription</h1>
            <?php
                include("../Form/inscription.form.php");
            ?>
        </div>
        <div id="div_right">
            &nbsp;
        </div>
    </section>
    <footer>
        &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
    </footer>

</body>
</html>