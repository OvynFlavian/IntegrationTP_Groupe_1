<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 19:31
 */
use \Entity\User as User;

/**
 *Fonction permettant d'aller rechercher en BDD tous les membres contenant le string contenu dans le formulaire de
 * recherche de nom.
 * @return array : la liste des membres trouvés.
 */
function rechercheMembre()
{
    if (isPostFormulaire()) {
        $name = $_POST['userName'];

    } else {
        $name = "";
    }

    $um = new UserManager(connexionDb());
    $tab = $um->searchAllUserByName($name);
    return $tab;
}

/**
 * Fonction affichant tous les membres contenus dans un tableau donné.
 * @param $tab : le tableau de membres.
 */
function afficherMembres($tab) {
    $existe = false;
    ?>
    <div class="Membres">
    <div class="table-responsive">
         <table class="table table-striped">
             <caption> <h2> Membres </h2></caption>
             <tr>
                 <th> Nom d'utilisateur</th>
                 <th> Dernière connexion</th>
                 <th> Date d'inscription</th>
                 <th> Demande d'ami</th>
             </tr>
             <?php
                foreach ($tab as $elem) {
                    $id = $elem->getId();
                    if ($id != $_SESSION['User']->getId()) {
                        echo "<tr> <td>" . $elem->getUserName() . " </td><td>" . $elem->getDateLastConnect() . "</td><td>" . $elem->getDateInscription() . "</td><td><a href='demandeAmi.page.php?membre=$id'> Ajouter comme ami</a></td></tr>";
                        $existe = true;
                    }


                }
                if ($tab == NULL or !$existe) {
                    echo "<tr> <td> Aucun utilisateur trouvé !</td></tr>";
                }
             ?>
         </table>
    </div>
    </div>
<?php
}
?>