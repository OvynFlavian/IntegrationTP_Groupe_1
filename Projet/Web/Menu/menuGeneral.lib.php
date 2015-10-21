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
            <a class="navbar-brand" href="/Web/">EveryDayIdea</a>
        </div>
    <div>
        <ul class="nav navbar-nav">
<?php if($isIndex){?>
            <li <?php if($isIndex) echo "class='active'"?>><a href="/Web/">Home</a></li>
            <?php if(!$isConnect){?>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="Page/connexion.page.php">Connexion</a></li>
            <li <?php if($page == "inscription") echo "class='active'"?>><a href="Page/inscription.page.php">Inscription</a></li>
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
            <?php }else{ ?>
            <li <?php if($page == "ajouterActivite") echo "class='active'"?>><a href="Page/ajouterActivite.page.php">Ajouter une activité</a></li>
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
            <li <?php if($page == "profil") echo "class='active'"?>><a href="Page/profil.page.php">Profil</a></li>
            <?php if($userSession->getDroit()[0]->getLibelle() == "Administrateur"){?>
            <li <?php if($page == "administration") echo "class='active'"?>><a href="Page/administration.page.php">Administration</a></li>
            <?php }?>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="Page/connexion.page.php">Déconnexion</a></li>
            <?php }?>
<?php }else{?>
            <li <?php if($page == "index") echo "class='active'"?>><a href="/Web/">Home</a></li>
            <?php if(!$isConnect){?>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="connexion.page.php">Connexion</a></li>
            <li <?php if($page == "inscription") echo "class='active'"?>><a href="inscription.page.php">Inscription</a></li>
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="Page/choisirCategorie.page.php">Catégorie</a></li>
            <?php }else{ ?>
            <li <?php if($page == "ajouterActivite") echo "class='active'"?>><a href="Page/ajouterActivite.page.php">Ajouter une activité</a></li>
            <li <?php if($page == "choisirCategorie") echo "class='active'"?>><a href="choisirCategorie.page.php">Catégorie</a></li>
            <li <?php if($page == "profil") echo "class='active'"?>><a href="profil.page.php">Profil</a></li>
            <?php if($userSession->getDroit()[0]->getLibelle() == "Administrateur"){?>
            <li <?php if($page == "administration") echo "class='active'"?>><a href="administration.page.php">Administration</a></li>
            <?php }?>
            <li <?php if($page == "connexion") echo "class='active'"?>><a href="connexion.page.php">Déconnexion</a></li>
            <?php }?>
<?php }?>
            </ul>
        </div>
    </div>
</nav>