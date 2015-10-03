<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 3/10/2015
 * Time: 16:59
 */
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
                $loginValable = 0;
                $emailValable = 0;
                $manager = new UserManager(connexionDb());
                $tbUser = $manager->getAllUser();
                foreach ($tbUser as $elem) {
                    $test = new User($elem);
                    if ($userName == $test->getUserName()) {
                        $loginValable = 1;
                    }
                    if ($email == $test->getEmail()) {
                        $emailValable = 1;
                    }
                }
                if ($loginValable == 1) {
                    echo "Ce login est déjà pris, veuillez en choisir en autre ! <br>";
                } else if ($emailValable == 1) {
                    echo "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                } else if (!champsEmailValable($email)) {
                    echo "Votre adresse mail contient des caractères indésirables !";
                } else if (!champsLoginValable($userName)) {
                    echo "Votre nom d'utilisateur contient des caractères indésirables !";
                } else if (!champsMdpValable($mdp)) {
                    echo "Votre mot de passe contient des caractères indésirables !";
                } else if ($loginValable == 0 && $emailValable == 0) {
                    $code_aleatoire = genererCode();
                    $adresseAdmin = "andrewblake@hotmail.fr";
                    $to = $email;
                    $sujet = "Confirmation de l'inscription";
                    $entete = "From:" . $adresseAdmin . "\r\n";
                    $message = "Nous confirmons que vous êtes officiellement inscrit sur le site EveryDayIdea <br>
									Votre login est : " . $_POST['userName'] . " <br>
									Votre email est : " . $_POST['email'] . " <br>
									Votre lien d'activation est : <a href='www.everydayidea/activation.php&code=" . $code_aleatoire . "'>www.everydayidea/activation.php&code=" . $code_aleatoire . "</a>";
                    mail($to, $sujet, $message, $entete);
                    echo "Votre inscription est dorénavant complète ! Un email vous a été envoyé avec vos informations et votre code d'activation !";
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;

    }
