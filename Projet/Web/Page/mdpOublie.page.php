<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/constante.lib.php";
require "../Library/Page/mdpOublie.lib.php";
require "../Library/Fonctions/Fonctions.php";
initRequire();

require "../Entity/User.class.php";
require "../Manager/UserManager.manager.php";

require "../Entity/Activation.class.php";
require "../Manager/ActivationManager.manager.php";

startSession();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MdpOublie</title>
    <script type="text/javascript">
        <?php
            include("../Script/mdpOublie.js");
        ?>
    </script>
</head>
<body>
<?php
echo "<p>Page Mot de passe oublié</p>";
if (!isset($_GET['code'])){
    formulaireMail();
    envoiCode();
} else {
    formulaireChangement();
    changementMdp();
}
?>

</body>
</html>