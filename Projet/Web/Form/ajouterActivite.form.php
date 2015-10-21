
<form method="post" action="ajouterActivite.page.php" onSubmit='return verification_ajouterActivite()'>

    <div class="form-group col-sm-12">
        <label class="control-label col-sm-2" for="categorie">Catégorie:</label>
        <div class="col-sm-10">
            <select name="categorie" id="categorie">
           <?php
            $cm = new CategorieManager(connexionDb());
            $tab = $cm->getAllCategorie();
            foreach($tab as $elem) {
                $cat= $elem->getLibelle();
                echo "<option value='$cat'>$cat</option>";
            }
           ?>
            </select>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-2" for="activite">Activité:</label>
        <div class="col-sm-10">
           <input type="text" class="form-control" id="activite" name="activite" placeholder="Votre activité">
        </div>
    </div>
    <div class="form-group col-sm-12">
        <div class="col-sm-offset-2 col-sm-12">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Submit</button>
        </div>
    </div>
</form>