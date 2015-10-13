<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 13/10/2015
 * Time: 14:38
 */
$runningFile = $_SERVER['PHP_SELF'];
$url = explode("/", $runningFile);
$pages = explode(".", $url[3]);
$page = $pages[0];
var_dump($page);
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">EveryDayIdea</a>
        </div>
    <div>
        <ul class="nav navbar-nav">
<?php if($url[3] == "index.php"){?>

                <li <?php if($page == "index") echo "class='active'"?>><a href="">Home</a></li>
                <?php if(!$isConnect){?>
                    <li <?php if($page == "connexion") echo "class='active'"?>><a href="./Page/connexion.page.php">Connexion</a></li>
                    <li <?php if($page == "inscription") echo "class='active'"?>><a href="./Page/inscription.page.php">Inscription</a></li>
                <?php }else{ ?>
                    <li <?php if($page == "profil") echo "class='active'"?>><a href="./Page/profil.page.php">Profil</a></li>
                    <li <?php if($page == "connexion") echo "class='active'"?>><a href="./Page/connexion.page.php">Déconnexion</a></li>
                <?php }?>
<?php }else{?>
                <li <?php if($page == "index") echo "class='active'"?>><a href="../">Home</a></li>
                    <?php if(!$isConnect){?>
                        <li <?php if($page == "connexion") echo "class='active'"?>><a href="../Page/connexion.page.php">Connexion</a></li>
                        <li <?php if($page == "inscription") echo "class='active'"?>><a href="../Page/inscription.page.php">Inscription</a></li>
                    <?php }else{ ?>
                        <li <?php if($page == "profil") echo "class='active'"?>><a href="../Page/profil.page.php">Profil</a></li>
                        <li <?php if($page == "connexion") echo "class='active'"?>><a href="../Page/connexion.page.php">Déconnexion</a></li>
                    <?php }?>

<?php }?>
            </ul>
        </div>
    </div>
</nav>