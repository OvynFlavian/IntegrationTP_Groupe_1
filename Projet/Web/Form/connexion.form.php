<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/10/2015
 * Time: 22:07
 */
?>

<form class="form-horizontal" action="connexion.page.php" method="post">
    <div class="form-group">
        <label class="control-label col-sm-2" for="userName">Login:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Votre pseudo" required>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="mdp">Mot de passe:</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Se Connecter</button>
            <a href="./mdpOublie.page.php"> Mot de passe oublié ? </a>
        </div>
    </div>
</form>

<!--<form action="./connexion.page.php" method="post">
    <label for="userName">Login :</label>
    <input type="text" name="userName" id="userName">
    <label for="mdp">Password :</label>
    <input type="password" name="mdp" id="mdp">
    <button type="submit" name="formulaire">Connexion</button>
</form>-->