<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
require "../Library/database.lib.php";
require "../Entity/User.class.php";
require "../Manager/UserManager.manager.php";
require "../Library/config.lib.php";
require "../Library/Fonctions/Fonctions.php";
require "../Library/post.lib.php";
require "../Library/session.lib.php";
require "../Entity/Activation.class.php";
require "../Manager/ActivationManager.manager.php";

require "../Library/Page/mdpOublie.lib.php";

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