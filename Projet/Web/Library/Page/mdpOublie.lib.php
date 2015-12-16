<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */

use \Entity\Activation as Activation;
/**
 * Si l'user arrive sur la page sans code dans l'url, la page lui met le formulaire demandant son email et
 * permettant l'envoi d'un code de changement de mdp
 */
 function formulaireMail() {
         include "../Form/mdpOublieMail.form.php";
 }

/**
 * Si l'user envoie le formulaire pour recevoir un code, la fonction vérifie si son email existe et envoie
 * un mail contenant l'url contenant le code d'activation à cette adresse. La fonction ajoute aussi le code
 * à la BDD
 */
  function envoiCode() {
      if (isset($_POST['email']) && !empty($_POST['email'])) {
          $ini = getConfigFile();
          $email = $_POST['email'];
          $um = new UserManager(connexionDb());
          $userToSend = $um->getUserByEmail($email);
          $inconnu = false;
          if ($userToSend->getId() == NULL) {
              $inconnu = true;
          }

          if ($inconnu) {
              echo "<div class='alert alert-danger' role='alert'>Cet email n'est pas répertorié chez nous, désolé !</div>";
          } else {
              $code_aleatoire = genererCode();
              $adresseAdmin = $ini['ADMINISTRATEUR']['mail'];
              $to = $email;
              $sujet = "Confirmation de la demande du mot de passe";
              $entete="From:".$adresseAdmin."\r\n";
              $entete .= "Content-Type: text/html; charset=utf-8\r\n";
              $message = "Nous confirmons que vous avez bien demandé un nouveau mot de passe : <br>
							Votre lien pour pouvoir le modifier est : <a href='http://www.everydayidea.be/Page/mdpOublie.page.php?code=" . $code_aleatoire . "'>www.everydayidea/mdpOublie.page.php?code=" . $code_aleatoire . "</a>";
              mail($to, $sujet, $message, $entete);
              echo "<div class='alert alert-success' role='alert'>Un mail vous a été envoyé avec un code d'activation pour le changement de votre mot de passe !</div>";

              $am = new ActivationManager(connexionDb());
              $ac = new Activation(array(
                  "code" => $code_aleatoire,
                  "id_user" => $userToSend->getId(),
                  "libelle" => "Récupération",
              ));




              /**
               * Si le user possède déjà un code de récupération de mdp, je le delete pour lui en mettre un nouveau
               */

              $actDelete = $am->getActivationByLibelleAndId('Récupération',$userToSend->getId());

              if ($actDelete->getCode() == NULL)
              {
                  $am->deleteActivationByIdAndLibelle($actDelete->getIdUser(), 'Récupération');
              }

              $am->addActivation($ac);
          }
      }
  }

/**
 * Fonction vérifiant si le code d'activation est correct.
 * @return bool : Renvoie si le code dans l'url existe ou non
 */
    function goodCode() {

            $code = $_GET['code'];
            $wrongCode = false;
            $am = new ActivationManager(connexionDb());
            $ac = $am->getActivationByCodeAndLibelle("Récupération", $code);

            if ($ac->getCode() == NULL) {
                $wrongCode = true;
            }

            if ($wrongCode && !isset($_POST['modifMdp'])) {
                echo "<div class='alert alert-danger' role='alert'> Votre code n'est pas correct, cliquez bien sur le mail envoyé à cet effet ! <br>";
                echo "<meta http-equiv='refresh' content='2; URL=../'>";
                return false;
            } else {
                return true;
            }

    }

/**
 * Fonction activant le formulaire de changement de mdp si le code existe bien en BDD, le formulaire doit posséder la
 * variable $code dans son action pour éviter de renvoyer à la page de demande d'adresse mail.
 */
    function formulaireChangement() {
        if (goodCode()) {
            $code = $_GET['code'];
            echo "<div class='col-sm-12'>";
            echo "<form class='form-horizontal' name='validation' action='mdpOublie.page.php?code=$code' method='post' onSubmit='return verification_validation()'>";
            echo "<div class='form-group col-sm-12'><label class='col-sm-2' for='userName'>Nom d'utilisateur :</label><div class='col-sm-10'><input class='form-control' id='userName' name='userName' type='text'></div></div>";
            echo "<div class='form-group col-sm-12'><label class='col-sm-2' for='mdp'>Mot de passe :</label><div class='col-sm-10'><input class='form-control' id='mdp' name='mdp' type='password'></div></div>";
            echo "<div class='form-group col-sm-12'><label class='col-sm-2' for='verifmdp'>Vérification du mdp :</label><div class='col-sm-10'><input class='form-control' id='verifmdp' name='verifmdp' type='password'></div></div>";
            echo "<div class='form-group col-sm-12'><div class='col-sm-offset-2 col-sm-10'><button type='submit' name='modifMdp' class='btn btn-default'>Soumettre</button></div></div> ";
            echo "</form>";
            echo "</div>";
        } else {
            echo " Revenez avec un code correct ! </div><br>";
        }
    }

/**
 * Si le user a rempli le formulaire de changement de mdp, la fonction regarde si le login correspond au user
 * possédant ce code d'activation et si cela est vrai, il change son mdp en bdd et delete son code d'activation en BDD
 */
    function changementMdp() {
        if (isset($_POST['userName']) && isset($_POST['mdp']) && $_POST['mdp'] == $_POST['verifmdp'] && goodCode()) {
            $code = $_GET['code'];
            $mdp = $_POST['mdp'];
            $userName = $_POST['userName'];
            $am = new ActivationManager(connexionDb());
            $ac = $am->getActivationByCodeAndLibelle("Récupération", $code);

            $userId = $ac->getIdUser();

            $um = new UserManager(connexionDb());
            /**
             * Je récupère cet user grâce à l'id du user possédant le code d'acti
             */
            $userRecup = $um->getUserById($userId);
            /**
             * Je récupère l'autre user grâce au login qu'il a encodé dans le formulaire
             */
            $userTest = $um->getUserByUserName($userName);
            /**
             * Je compare les deux users pour voir si ce sont les mêmes
             */
            if ($userTest->getUserName() != $userRecup->getUserName() ) {

                echo "<section class='row'>";
                echo "<br><br><br><br><br><br><br><br><br><br><br><br><div class='alert alert-danger' role='alert'>Votre nom d'utilisateur ne correspond pas à l'utilisateur possédant ce code d'activation !</div>";
                echo "</section>";


            } else {

                $userRecup -> setMdp($mdp);
                $am->deleteActivation($ac);
                $um->updateUserMdp($userRecup);
                echo "<br><br><br><br><br><br><br><br><br><br><br><br><div class='alert alert-success' role='success'>Votre mot de passe a bien été modifié, vous pouvez vous connecter !</div>";
                echo "<meta http-equiv='refresh' content='2; URL=connexion.page.php'>";

            }
        }

}