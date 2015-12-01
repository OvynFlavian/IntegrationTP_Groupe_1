
<form method="post" enctype="multipart/form-data" action="ajouterActivite.page.php">

    <div class="form-group col-sm-12">
        <label class="control-label col-sm-2" for="categorie">Catégorie:</label>
        <div class="col-sm-10">
            <span class="col-sm-8" style="text-align: right">Dans quelle catégorie voulez vous ajouter l'activité ?</span>
            <select class="col-sm-2 form-control" name="categorie" id="categorie" style="text-align: center">
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
        <label class="control-label col-sm-2" for="activite">Activité : <br> (5 à 100 caractères)</label>
        <div class="col-sm-10">
           <input type="text" class="form-control" id="activite" name="activite" placeholder="Votre activité" required>
        </div>
    </div>

    <div class="form-group col-sm-12">
        <label class="control-label col-sm-2" for="description">Description:</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="5" id="description" name="description" placeholder="Description de votre activité" required></textarea>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-2" for="image">Image: <br> (Uniquement Jpg pour le moment)</label>
        <div class="col-sm-10">

            <input name="image" class="file" id="image" size="30" type="file" required /> <br>

        </div>
    </div>
    <div class="form-group col-sm-12">
        <div class="col-sm-offset-2 col-sm-12">
            <button type="submit" class="btn btn-default" name="formulaire" id="formulaire">Publier mon activité </button>
        </div>
    </div>
</form>