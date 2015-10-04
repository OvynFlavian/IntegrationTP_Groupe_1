<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 3/10/2015
 * Time: 16:59
 */
    function isValidBis()
    {
        $tabReturn = array("Retour" => false, "Error" => array());
        if(isset($_POST['emailConfirm']) && $_POST['mdp'] == $_POST['mdpConfirm'] && $_POST['email'] == $_POST['emailConfirm'])
        {
            $ini = getConfigFile();
            $userName = strtolower($_POST['userName']);
            $mdp = $_POST['mdp'];
            $email = $_POST['email'];

            if(strlen($userName) < $ini['CONSTANTE']['size_user_name'])
                $tabReturn['Error'][] = "Votre nom d'utilisateur est trop court, 6 caractères minimum ! <br>";

            if(strlen($mdp) < $ini['CONSTANTE']['size_user_mdp'])
                $tabReturn['Error'][] = "Votre mot de passe est trop court, 5 caractères minimum ! <br>";
            else
            {
                $um = new UserManager(connexionDb());
                $tabUser = $um->getAllUser();
                $validUserName = true;
                $validUserMail = true;
                $champValid = true;
                foreach($tabUser as $userTest)
                {
                    if($userName == strtolower($userTest->getUserName()))
                        $validUserName = false;
                    if($email == $userTest->getEmail())
                        $validUserMail = false;
                }
                if(!$validUserMail)
                    $tabReturn['Error'][] = "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                if(!$validUserName)
                    $tabReturn['Error'][] = "Ce login est déjà pris, veuillez en choisir en autre ! <br>";

                if(!champsEmailValable($email))
                {
                    $tabReturn['Error'][] = "Votre adresse mail contient des caractères indésirables !";
                    $champValid = false;
                }
                if (!champsLoginValable($userName))
                {
                    $tabReturn['Error'][] = "Votre nom d'utilisateur contient des caractères indésirables !";
                    $champValid = false;
                }
                if (!champsMdpValable($mdp))
                {
                    $tabReturn['Error'][] = "Votre mot de passe contient des caractères indésirables !";
                    $champValid = false;
                }
                if($validUserMail and $validUserName and $champValid)
                    $tabReturn['Retour'] = true;

            }
        }
        return $tabReturn;
    }
    function isValid()
    {

        if(isset($_POST['emailConfirm']) && $_POST['mdp'] == $_POST['mdpConfirm'] && $_POST['email'] == $_POST['emailConfirm']) {
            $ini = getConfigFile();
            $userName = strtolower($_POST['userName']);
            $mdp = $_POST['mdp'];
            $email = $_POST['email'];
            if (strlen($userName) < $ini['CONSTANTE']['size_user_name']) {
                echo "Votre nom d'utilisateur est trop court, 6 caractères minimum ! <br>";
            } else if (strlen($mdp) < $ini['CONSTANTE']['size_user_mdp']) {
                echo "Votre mot de passe est trop court, 5 caractères minimum ! <br>";
            } else {
                $loginNonValable = false;
                $emailNonValable = false;
                $manager = new UserManager(connexionDb());
                $tbUser = $manager->getAllUser();
                foreach ($tbUser as $elem) {
                        echo "Test du user => $elem->getUserName()";
                        if ($userName == $elem->getUserName()) {
                            $loginNonValable = true;
                        }
                        if ($email == $elem->getEmail()) {
                            $emailNonValable = true;
                        }
                }
                if ($loginNonValable) {
                    echo "Ce login est déjà pris, veuillez en choisir en autre ! <br>";
                } else if ($emailNonValable) {
                    echo "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                } else if (!champsEmailValable($email)) {
                    echo "Votre adresse mail contient des caractères indésirables !";
                } else if (!champsLoginValable($userName)) {
                    echo "Votre nom d'utilisateur contient des caractères indésirables !";
                } else if (!champsMdpValable($mdp)) {
                    echo "Votre mot de passe contient des caractères indésirables !";
                } else if (!$loginNonValable && !$emailNonValable) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;

    }

    function addDB()
    {
        $userToAdd = new User(array(
            "UserName" => $_POST['userName'],
            "email" => $_POST['email'],
            "Mdp" => $_POST['mdp'],
        ));

        $code_aleatoire = genererCode();
        $adresseAdmin = "andrewblake@hotmail.fr";
        $to = $userToAdd->getEmail();
        $sujet = "Confirmation de l'inscription";
        $entete = "From:" . $adresseAdmin . "\r\n";
        $message = "Nous confirmons que vous êtes officiellement inscrit sur le site EveryDayIdea <br>
									Votre login est : " . $userToAdd->getUserName() . " <br>
									Votre email est : " . $userToAdd->getEmail() . " <br>
									Votre lien d'activation est : <a href='www.everydayidea/activation.php?code=" . $code_aleatoire . "'>www.everydayidea/activation.php?code=" . $code_aleatoire . "</a>";
        mail($to, $sujet, $message, $entete);
        echo "Votre inscription est dorénavant complète ! Un email vous a été envoyé avec vos informations et votre code d'activation !";
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
