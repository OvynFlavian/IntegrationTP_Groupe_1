<?php function administrationEditConfig(){
    $configArray = getConfigFile();
    ?>
    <form class="form-horizontal" action="?to=editConfig" method="post">
        <table>
        <?php foreach($configArray as $section => $element){?>
            <?php if($section != 'DATABASE'){?>
            <tr><td><div style="font-weight: bold"><?php echo $section ;?></div></td></tr>
                <?php foreach($element as $labelElem => $elemElement){?>
                <tr class="form-group">
                    <td class="col-sm-2"><label style="font-weight: normal" for="<?php echo $labelElem?>"><?php echo $labelElem?></label></td>
                    <td class="col-sm-10">
                        <input type="text" class="form-control" id="<?php echo $labelElem?>" name="<?php echo $labelElem?>" value="<?php echo $elemElement?>"> <br>
                    </td>
                </tr>
                <?php }?>

                <?php }?>
        <?php }?>
            <tr><td><div style="font-weight: bold">Mot de passe Admin </div></td></tr>
            <tr class="form-group">
                <td class="col-sm-2"><label style="font-weight: normal" for="mdp"> Votre mot de passe administrateur : </label></td>
                <td class="col-sm-10">
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Rentrez votre mot de passe ici"required> <br>
                </td>
            </tr>
        </table>
        <br>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn-block btn-primary btn-lg" name="formulaire" id="formulaire">Soumettre</button>
            </div>
        </div>
    </form>
<?php }?>

<?php function administrationViewConfig(){
    $configArray = getConfigFile();
    ?>
    <form class="form-horizontal" action="?to=editConfig" method="post">
        <div class="form-group">
            <?php foreach($configArray as $section => $element){?>
               <?php if($section != 'DATABASE'){?>
                <div class="col-sm-12" style="font-weight: bold;"><p style="text-decoration: underline"><?php echo $section?></p></div>
                <?php foreach($element as $labelElem => $elemElement){?>
                    <div class="form-group col-sm-10">
                        <span class="col-sm-2">&nbsp;</span>
                        <span class="col-sm-2"><label style="font-weight: normal" for="<?php echo $labelElem?>"><?php echo $labelElem?></label></span>
                        <span class="col-sm-8"><?php echo $elemElement?></span>
                    </div>
                <?php }?>
                <div class="col-sm-12"><hr size="50"></div>
                <?php }?>
            <?php }?>
        </div>
    </form>
<?php }?>

