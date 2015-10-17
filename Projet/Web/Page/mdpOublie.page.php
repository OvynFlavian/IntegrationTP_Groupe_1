<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/constante.lib.php";
require "../Library/Fonctions/Fonctions.php";

initRequire();
initRequirePage("mdpOublie");
initRequireEntityManager();

startSession();

if(isConnect())header("Location:../");
$configIni = getConfigFile();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MdpOublie</title>
    <link rel="stylesheet" type="text/css" href="../Style/presentationCss.css">
    <script type="text/javascript">
        <?php
            include("../Script/mdpOublie.js");
        ?>
    </script>
</head>
<body>
    <header>
        <?php
            include("..". MENU_ANONYME_PAGE);
        ?>
    </header>
    <section id="section_corps">
        <div id="div_left">&nbsp;</div>
        <div id="div_center">
            <h1>Page Mot de passe oublié</h1>
            <?php
                if (!isset($_GET['code']))
                {
                    formulaireMail();
                    envoiCode();
                }
                else
                {
                    formulaireChangement();
                    changementMdp();
                }
            ?>
        </div>
        <div id="div_right">&nbsp;</div>
    </section>
    <footer>
        &copy; everydayidea.com. Contactez <a href="mailto:<?php echo $configIni['ADMINISTRATEUR']['mail']?>">l'administrateur</a>
    </footer>

</body>
</html>