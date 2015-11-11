<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 13/10/2015
 * Time: 14:38
 */

$page = getCurrentPage();
$userSession = getSessionUser();
$isIndex = ($page == '' or $page == "index");

?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <?php
            if ($isIndex) {
                $lien = "index.php";
            } else {
                $lien = "../index.php";
            }

            echo "<a class='navbar-brand' href='$lien'>EveryDayIdea</a>";
            ?>
        </div>
    <div>
        <ul class="nav navbar-nav">
<?php if($isIndex){?>
            <li <?php if($isIndex) echo "class='active'"?>><a href="index.php">Accueil</a></li>
            <?php if(!$isConnect){?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li <?php if($page == "inscription") echo "class='active'"?>><a href="Page/inscription.page.php">Inscription</a></li>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="Page/connexion.page.php" >Connexion</a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
            <?php }else{ ?>
            <li <?php if($page == "ajouterActivite") echo "class='active'"?>><a href="Page/ajouterActivite.page.php">Ajouter une activité</a></li>
            <li <?php if($page == "listeMembres") echo "class='active'"?>><a href="Page/listeMembres.page.php">Membres</a></li>
            <li <?php if($page == "amis") echo "class='active'"?>><a href="Page/amis.page.php">Amis</a></li>
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
            <?php if($userSession->getDroit()[0]->getLibelle() == "Administrateur"){?>
                <li <?php if($page == "administration") echo "class='active'"?>><a href="Page/administration.page.php">Administration</a></li>
            <?php }?>
            <?php if($userSession->getDroit()[0]->getId() == 1 || $userSession->getDroit()[0]->getId() == 2){?>
                <li <?php if($page == "activiteSignalee") echo "class='active'"?>><a href="Page/activiteSignalee.page.php">Signalement</a></li>
            <?php }?>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><?php buttonPaypal()?></li>
            <li <?php if($page == "profil") echo "class='active'"?>><a href="Page/profil.page.php">Profil</a></li>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="Page/connexion.page.php">Déconnexion</a></li>
            <?php }?>
        </ul>
<?php }else{?>

            <li <?php if($page == "index") echo "class='active'"?>><a href="../index.php">Accueil</a></li>
            <?php if(!$isConnect){?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li <?php if($page == "inscription") echo "class='active'"?>><a href="inscription.page.php">Inscription</a></li>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="connexion.page.php">Connexion</a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="choisirCategorie.page.php">Catégorie</a></li>
            <?php }else{ ?>
            <li <?php if($page == "ajouterActivite") echo "class='active'"?>><a href="ajouterActivite.page.php">Ajouter une activité</a></li>
            <li <?php if($page == "listeMembres") echo "class='active'"?>><a href="listeMembres.page.php">Membres</a></li>
            <li <?php if($page == "amis") echo "class='active'"?>><a href="amis.page.php">Amis</a></li>
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="choisirCategorie.page.php">Catégorie</a></li>

            <?php if($userSession->getDroit()[0]->getLibelle() == "Administrateur"){?>
            <li <?php if($page == "administration") echo "class='active'"?>><a href="administration.page.php">Administration</a></li>
            <?php }?>
            <?php if($userSession->getDroit()[0]->getId() == 1 || $userSession->getDroit()[0]->getId() == 2){?>
            <li <?php if($page == "activiteSignalee") echo "class='active'"?>><a href="activiteSignalee.page.php">Signalement</a></li>
            <?php }?>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><?php buttonPaypal()?></li>
            <li <?php if($page == "profil") echo "class='active'"?>><a href="profil.page.php">Profil</a></li>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="connexion.page.php">Déconnexion</a></li>
        </ul>
            <?php }?>
<?php }?>

        </div>
    </div>
</nav>