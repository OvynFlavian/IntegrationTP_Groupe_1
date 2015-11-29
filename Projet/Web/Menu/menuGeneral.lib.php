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
        <div class="navbar-header col-lg-2 col-md-2 text-left">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            if ($isIndex) {
                $lien = "index.php";
                $img = "Images/logo.png";
            } else {
                $lien = "../index.php";
                $img = "../Images/logo.png";
            }

            echo "<img class='menulogo' src='$img' height='35px' width='35px' alt='logo' /><a class='navbar-brand' href='$lien'>EveryDayIdea</a>";
            ?>
        </div>
    <div class="container-fluid collapse navbar-collapse">
        <?php if($isIndex){?>
            <ul class="nav navbar-nav col-lg-10">
                <?php if(!$isConnect){?>
                    <li class="col-md-3"></li>
                    <li <?php if($isIndex) echo "class='active'"?>><a href="index.php">Accueil</a></li>
                    <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
                    <li <?php if($page == "inscription") echo "class='active'"?>><a href="Page/inscription.page.php">Inscription</a></li>
                    <li <?php if($page == "connexion") echo "class='active'"?>><a href="Page/connexion.page.php" >Connexion</a></li>
                <?php }else{ ?>
                    <li class="col-md-2"></li>
                    <li <?php if ($page == "ajouterActivite") echo "class='active'" ?>><a href="Page/ajouterActivite.page.php">Ajouter une activité</a></li>
                    <li <?php if($page == "listeMembres") echo "class='active'"?>><a href="Page/listeMembres.page.php">Membres</a></li>
                    <li <?php if($page == "amis") echo "class='active'"?>><a href="Page/amis.page.php">Amis</a></li>
                    <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
                    <?php if($userSession->getDroit()[0]->getLibelle() == "Administrateur"){?>
                        <li <?php if($page == "administration") echo "class='active'"?>><a href="Page/administration.page.php">Administration</a></li>
                    <?php }?>
                    <?php if($userSession->getDroit()[0]->getId() == 1 || $userSession->getDroit()[0]->getId() == 2){?>
                        <li <?php if($page == "activiteSignalee") echo "class='active'"?>><a href="Page/activiteSignalee.page.php">Signalement</a></li>
                    <?php }?>
                    <?php if($userSession->getDroit()[0]->getId() == 3 || $userSession->getDroit()[0]->getId() == 2 || $userSession->getDroit()[0]->getId() == 1 ){?>
                        <li <?php if($page == "groupe") echo "class='active'"?>><a href="Page/groupe.page.php">Groupe</a></li>
                    <?php }?>
                    <?php if($_SESSION['User']->getDroit()[0]->getLibelle() != 'Premium' and $_SESSION['User']->getDroit()[0]->getLibelle() != 'Administrateur' and $_SESSION['User']->getDroit()[0]->getLibelle() != 'Moderateur') { ?>
                        <li <?php if($page == "premium") echo "class='active'"?>><a href="Page/premium.page.php">Devenir Premium</a></li>
                    <?php } ?>
                    <li <?php if($page == "profil") echo "class='active'"?>><a href="Page/profil.page.php">Profil</a></li>
                    <li <?php if($page == "connexion") echo "class='active'"?>><a href="Page/connexion.page.php">Déconnexion</a></li>
                <?php }?>
            </ul>
        <?php }else{?>
            <ul class="nav navbar-nav col-lg-10">
                <?php if(!$isConnect){?>
                    <li class="col-md-3"></li>
                    <li <?php if($isIndex) echo "class='active'"?>><a href="../index.php">Accueil</a></li>
                    <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="choisirCategorie.page.php">Catégorie</a></li>
                    <li <?php if($page == "inscription") echo "class='active'"?>><a href="inscription.page.php">Inscription</a></li>
                    <li <?php if($page == "connexion") echo "class='active'"?>><a href="connexion.page.php" >Connexion</a></li>
                <?php }else{ ?>
                    <li class="col-md-2"></li>
                    <li <?php if ($page == "ajouterActivite") echo "class='active'" ?>><a href="ajouterActivite.page.php">Ajouter une activité</a></li>
                    <li <?php if($page == "listeMembres") echo "class='active'"?>><a href="listeMembres.page.php">Membres</a></li>
                    <li <?php if($page == "amis") echo "class='active'"?>><a href="amis.page.php">Amis</a></li>
                    <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="choisirCategorie.page.php">Catégorie</a></li>
                    <?php if($userSession->getDroit()[0]->getLibelle() == "Administrateur"){?>
                        <li <?php if($page == "administration") echo "class='active'"?>><a href="administration.page.php">Administration</a></li>
                    <?php }?>
                    <?php if($userSession->getDroit()[0]->getId() == 1 || $userSession->getDroit()[0]->getId() == 2){?>
                        <li <?php if($page == "activiteSignalee") echo "class='active'"?>><a href="activiteSignalee.page.php">Signalement</a></li>
                    <?php }?>
                    <?php if($userSession->getDroit()[0]->getId() == 3 || $userSession->getDroit()[0]->getId() == 2 || $userSession->getDroit()[0]->getId() == 1 ){?>
                        <li <?php if($page == "groupe") echo "class='active'"?>><a href="groupe.page.php">Groupe</a></li>
                    <?php }?>
                    <?php if($_SESSION['User']->getDroit()[0]->getLibelle() != 'Premium' and $_SESSION['User']->getDroit()[0]->getLibelle() != 'Administrateur' and $_SESSION['User']->getDroit()[0]->getLibelle() != 'Moderateur') { ?>
                        <li <?php if($page == "premium") echo "class='active'"?>><a href="premium.page.php">Devenir Premium</a></li>
                    <?php } ?>
                    <li <?php if($page == "profil") echo "class='active'"?>><a href="profil.page.php">Profil</a></li>
                    <li <?php if($page == "connexion") echo "class='active'"?>><a href="connexion.page.php">Déconnexion</a></li>
                <?php }?>
            </ul>
        <?php }?>
        </div>
</nav>