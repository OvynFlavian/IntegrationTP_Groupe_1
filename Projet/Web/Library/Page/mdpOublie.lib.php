<?php
/**
 * Created by PhpStorm.
 * User: JulienTour
 * Date: 4/10/2015
 * Time: 21:08
 */
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
          if (empty($userToSend->getId())) {
              $inconnu = true;
          }

          if ($inconnu) {
              echo "Cet email n'est pas répertorié chez nous, désolé !";
          } else {
              $code_aleatoire = genererCode();
              $adresseAdmin = $ini['ADMINISTRATEUR']['mail'];
              $to = $email;
              $sujet = "Confirmation de la demande du mot de passe";
              $entete="From:".$adresseAdmin."\r\n";
              $entete .= "Content-Type: text/html; charset=utf-8\r\n";
              $message = "Nous confirmons que vous avez bien demandé un nouveau mot de passe : <br>
							Votre lien pour pouvoir le modifier est : <a href='www.everydayidea/mdpOublie.php?code=" . $code_aleatoire . "'>www.everydayidea/mdpOublie.php?code=" . $code_aleatoire . "</a>";
              mail($to, $sujet, $message, $entete);
              echo "Un mail vous a été envoyé avec un code d'activation pour le changement de votre mot de passe !";

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

              if (!empty($acDelete->getCode()))
              {
                  $am->deleteActivationByIdAndLibelle($actDelete->getIdUser(), 'Récupération');
              }

              $am->addActivation($ac);
          }
      }
  }

/**
 * @return bool : Renvoie si le code dans l'url existe ou non
 */
    function goodCode() {

            $code = $_GET['code'];
            $wrongCode = false;
            $am = new ActivationManager(connexionDb());
            $ac = $am->getActivationByCodeAndLibelle("Récupération", $code);

            if (empty($ac->getCode())) {
                $wrongCode = true;
            }

            if ($wrongCode) {
                echo "Votre code n'est pas correct, cliquez bien sur le mail envoyé à cet effet ! <br>";
                #TODO Ajoutez une redirection vers l'accueil
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
            echo "<form name='validation' action='www.everydayidea/mdpOublie.php?code=$code' method='post' onSubmit='return verification_validation()'>";
            echo "  Nom d'utilisateur :      						<input name='userName' type='text'> <br>";
            echo "   Mot de passe : 				<input name='mdp' type='password'> <br>";
            echo "    Vérification du mdp :		<input name='verifmdp' type='password'> <br>";
            echo "    <input type='submit' name='formulaire'>";
            echo "</form>";
        } else {
            echo "Revenez avec un code correct ! <br>";
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


                echo "Votre nom d'utilisateur ne correspond pas à l'utilisateur possédant ce code d'activation !";


            } else {

                $userRecup -> setMdp($mdp);
                $am->deleteActivation($ac);
                $um->updateUserMdp($userRecup);
                echo "Votre mot de passe a bien été modifié, vous pouvez vous connecter !";

            }
        }

    }