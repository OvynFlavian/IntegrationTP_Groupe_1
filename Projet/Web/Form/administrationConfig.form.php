<?php

/*A refaire*/

$configArray = getConfigFile();
?>
<form class="form-horizontal" action="?to=editConfig" method="POST">
    <table>
    <?php foreach($configArray as $section => $element){?>
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
    </table>
</form>
