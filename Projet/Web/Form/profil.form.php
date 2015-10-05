<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 5/10/2015
 * Time: 09:37
 */
?>
<form action="profil.page.php" method="post">
    <label for="UserName">Login : </label>
    <input type="text" id="UserName" name="UserName" value="<?php echo $user->getUserName() ?>">
    <br>
    <label for="Mdp">Password : </label>
    <input type="password" id="Mdp" name="Mdp" value="">
    <label for="MdpBis">Password verify: </label>
    <input type="password" id="MdpBis" name="MdpBis" value="">
    <br>
    <label for="Tel">Telephone : </label>
    <input type="text" id="Tel" name="Tel" value="<?php echo $user->getTel() ?>">
    <br>
    <button type="submit" id="formualire" name="formulaire">Modifier</button><button type="reset">Reset</button>
</form>