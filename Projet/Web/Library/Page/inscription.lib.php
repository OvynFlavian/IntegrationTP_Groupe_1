<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 3/10/2015
 * Time: 16:59
 */
    use \Entity\User as User;
    use \Entity\Activation as Activation;

/**
 * Fonction permettant de vérifier si le formulaire d'inscription est correct et ne contient pas d'erreurs.
 * @return array : un tableau contenant tous les messages d'erreurs liés au formulaire ou un booléen true si l'inscription
 * s'est bien passée.
 */
    function isValidBis()
    {
        $tabReturn = array("Retour" => false, "Error" => array());

            $ini = getConfigFile();
            $userName = strtolower($_POST['userName']);
            $mdp = $_POST['mdp'];
            $email = $_POST['email'];
            $emailConfirm = $_POST['emailConfirm'];
            $mdpConfirm = $_POST['mdpConfirm'];

            if (strlen($userName) < $ini['CONSTANTE']['size_user_name']) {
                $tabReturn['Error'][] = "Votre nom d'utilisateur est trop court, 6 caractères minimum ! <br>";
            }

            if (strlen($mdp) < $ini['CONSTANTE']['size_user_mdp']) {
                $tabReturn['Error'][] = "Votre mot de passe est trop court, 5 caractères minimum ! <br>";
            }
            if ($mdp != $mdpConfirm) {
                $tabReturn['Error'][] = "Les mots de passe ne correspondent pas ! <br>";
           }
            if ($email != $emailConfirm) {
                $tabReturn['Error'][] = "Les adresses mail ne correspondent pas ! <br>";
            }
                $um = new UserManager(connexionDb());
                $tabUser = $um->getAllUser();
                $validUserName = true;
                $validUserMail = true;
                $champValid = true;
                foreach ($tabUser as $userTest) {
                    if ($userName == strtolower($userTest->getUserName()))
                        $validUserName = false;
                    if ($email == $userTest->getEmail())
                        $validUserMail = false;
                }
                if (!$validUserMail)
                    $tabReturn['Error'][] = "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                if (!$validUserName)
                    $tabReturn['Error'][] = "Ce login est déjà pris, veuillez en choisir en autre ! <br>";

                if (!champsEmailValable($email)) {
                    $tabReturn['Error'][] = "Votre adresse mail contient des caractères indésirables !<br>";
                    $champValid = false;
                }
                if (!champsLoginValable($userName)) {
                    $tabReturn['Error'][] = "Votre nom d'utilisateur contient des caractères indésirables !<br>";
                    $champValid = false;
                }
                if (!champsMdpValable($mdp)) {
                    $tabReturn['Error'][] = "Votre mot de passe contient des caractères indésirables !<br>";
                    $champValid = false;
                }
                if ($validUserMail and $validUserName and $champValid)
                    $tabReturn['Retour'] = true;

                return $tabReturn;




    }

/**
 * Fonction ajoutant en BDD le nouveau membre inscrit et lui envoyant un message contenant son code d'activation
 * d'inscription.
 */
    function addDB()
    {
        $userToAdd = new User(array(
            "UserName" => $_POST['userName'],
            "email" => $_POST['email'],
            "Mdp" => $_POST['mdp'],
        ));

        $code_aleatoire = genererCode();
        $adresseAdmin = "no-reply@everydayidea.be";
        $to = $userToAdd->getEmail();
        $sujet = "Confirmation de l'inscription";
        $entete = "From:" . $adresseAdmin . "\r\n";
        $message = "Nous confirmons que vous êtes officiellement inscrit sur le site EveryDayIdea <br>
									Votre login est : " . $userToAdd->getUserName() . " <br>
									Votre email est : " . $userToAdd->getEmail() . " <br>
									Votre lien d'activation est : <a href='www.everydayidea.be/Page/activationInscription.page.php?code=" . $code_aleatoire . "'>Cliquez ici !</a>";
        mail($to, $sujet, $message, $entete);

        /** @var $um : un nouvel user qui va être ajouté à la BDD
        J'ajoute le nouvel user à la BDD*/
        $um = new UserManager(connexionDb());
        $um->addUser($userToAdd);

        /**
         * Ici j'ai besoin de savoir quel est le user id du nouveau membre ajouté pour pouvoir le mettre dans l'ajout du code d'activation de cet user
         * Donc je vais le rechercher en base de donnée où il vient d'être ajouté
         */
        $user = $um->getUserByUserName($userToAdd->getUserName());

        $userid = $user->getId();

        $um->setUserDroit($user, 4);
        /**
         * J'ajoute le nouveau code d'activation à la BDD
         */
        $am = new ActivationManager(connexionDb());
        $activation = new Activation(array(
            "code" => $code_aleatoire,
            "id_user" => $userid,
            "libelle" => "Inscription",
            ));
        $am->addActivation($activation);


    }
