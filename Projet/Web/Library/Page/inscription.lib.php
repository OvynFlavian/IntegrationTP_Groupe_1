<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 3/10/2015
 * Time: 16:59
 */
    function isValid()
    {
        if(isset($_POST['userName']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['mdpConfirm']) &&
            isset($_POST['emailConfirm']) && $_POST['mdp'] == $_POST['mdpConfirm'] && $_POST['email'] == $_POST['emailConfirm']) {
            $userName = strtolower($_POST['userName']);
            $mdp = $_POST['mdp'];
            $email = $_POST['email'];
            if (strlen($userName) < $ini['CONSTANTE']['size_user_name']) {
                echo "Votre nom d'utilisateur est trop court, 6 caract�res minimum ! <br>";
            } else if (strlen($mdp) < $ini['CONSTANTE']['size_user_mdp']) {
                echo "Votre mot de passe est trop court, 5 caract�res minimum ! <br>";
            } else {
                $loginValable = 0;
                $emailValable = 0;
                $tbUser = getAllUser();
                while ($resultat = $tbUser->fetch()) {
                    if ($userName == $resultat->userName) {
                        $loginValable = 1;
                    }
                    if ($email == $resultat->email) {
                        $emailValable = 1;
                    }
                }
                if ($loginValable == 1) {
                    echo "Ce login est d�j� pris, veuillez en choisir en autre ! <br>";
                }
                else if ($emailValable == 1) {
                    echo "Cette adresse mail est d�j� utilis�e, veuillez en choisir une autre ! <br>";
                }
                else if (!champsEmailValable($email)) {
                    echo "Votre adresse mail contient des caract�res ind�sirables !";
                }
                else if (!champsLoginValable($userName)) {
                    echo "Votre nom d'utilisateur contient des caract�res ind�sirables !";
                }
                else if (!champsMdpValable($mdp)) {
                    echo "Votre mot de passe contient des caract�res ind�sirables !";
                }
                else if ($loginValable == 0 && $emailValable == 0) {

                }
            }


            $user = new User(array(
                "UserName" => "Flavian",
                "Mdp" => "Flavian",
            ));

            $user->setMdp(hash("sha256", $user->getMdp()));
            $um->addUser($user);

            return false;
        }
    }
