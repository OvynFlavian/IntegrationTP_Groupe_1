<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 3/11/2015
 * Time: 19:31
 */
use \Entity\User as User;

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

function afficherMembres($tab) {
    ?>
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
                    echo "<tr> <td>".$elem->getUserName()." </td><td>".$elem->getDateLastConnect()."</td><td>".$elem->getDateInscription()."</td><td><a href='demandeAmi.page.php?membre=$id'> Ajouter comme ami</a></td></tr>";
                }
                if ($tab == NULL) {
                    echo "<tr> <td> Aucun utilisateur trouvé !</td></tr>";
                }
             ?>
         </table>
    </div>
<?php
}
?>