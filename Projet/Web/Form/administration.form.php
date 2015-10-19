<?php function administrationEditConfig(){
    $configArray = getConfigFile();
    ?>
    <form class="form-horizontal" action="?to=editConfig" method="POST">
        <table>
        <?php foreach($configArray as $section => $element){?>
            <?php if($section != 'DATABASE'){?>
            <tr><td><div style="font-weight: bold"><?php echo $section ;?></div></td></tr>
                <?php foreach($element as $labelElem => $elemElement){?>
                <tr class="form-group">
                    <td class="col-sm-2"><label style="font-weight: normal" for="<?php echo $labelElem?>"><?php echo $labelElem?></label></td>
                    <td class="col-sm-10">
                        <input type="text" class="form-control" id="<?php echo $labelElem?>" name="<?php echo $labelElem?>" value="<?php echo $elemElement?>">
                    </td>
                </tr>
                <?php }?>
                <?php }?>
        <?php }?>
        </table>
        <br>
        <button class="btn-block btn-primary btn-lg" type="submit" id="formulaire" name="formualire">Modifier</button>
    </form>
<?php }?>

<?php function administrationViewConfig(){
    $configArray = getConfigFile();
    ?>
    <form class="form-horizontal" action="?to=editConfig" method="POST">
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

<?php function administrationEditUser(UserManager $um){
    $listUser = $um->getAllUser();
    ?>
        <div class="form-group">
            <?php foreach($listUser as $user){
                $user->setDroit($um->getUserDroit($user))?>
            <div class="col-sm-12">
                <form class="form-horizontal" action="profil.page.php?to=viewProfilAdmin" method="post" id="view_user_<?php echo $user->getId();?>">
                <a onclick="doSubmit(<?php echo $user->getId();?>);">
                <span class="col-sm-4"><?php echo $user->getUserName();?></span>
                <span class="col-sm-4"><?php echo $user->getDroit()[0]->getLibelle();?></span>
                <span class="col-sm-4"><?php echo $user->getDateLastConnect();?></span>
                <input type="hidden" id="id_user" name="id_user" value="<?php echo $user->getId();?>">
                </a>
                </form>
            </div>
            <?php }?>
        </div>
<?php }?>
