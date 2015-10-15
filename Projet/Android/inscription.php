<?php

  define('HOST','localhost');
  define('USER','root');
  define('PASS','LUCIENNE1223');
  define('DB','projetintegration');

$con = mysqli_connect(HOST,USER,PASS,DB);


        $return = "error";
       // if(isset($_POST['mdp'] == $_POST['mdpConfirm'])
        if(1==1)
		{
            //$ini = getConfigFile();
            $userName = strtolower($_POST['userName']);
            $mdp = $_POST['mdp'];
            $email = $_POST['email'];

            if(strlen($userName) < 6)
                $return= "Votre nom d'utilisateur est trop court, 6 caractères minimum ! <br>";

            if(strlen($mdp) < 5)
                $return .="Votre mot de passe est trop court, 5 caractères minimum ! <br>";
            else
            {
                //$um = new UserManager(connexionDb());
               // $tabUser = $um->getAllUser();
               /* $validUserName = true;
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
                    $return .= "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                if(!$validUserName)
                    $return .= "Ce login est déjà pris, veuillez en choisir en autre ! <br>";

                if(!champsEmailValable($email))
                {
                    $return .= "Votre adresse mail contient des caractères indésirables !";
                    $champValid = false;
                }
                if (!champsLoginValable($userName))
                {
                    $return .= "Votre nom d'utilisateur contient des caractères indésirables !";
                    $champValid = false;
                }
                if (!champsMdpValable($mdp))
                {
                    $return .= "Votre mot de passe contient des caractères indésirables !";
                    $champValid = false;
                }
                if($validUserMail and $validUserName and $champValid)
                  */  $return= "true";
			  
				$sql="INSERT INTO user(userName, password, email) VALUES('".$userName."', '".$mdp."', '".$email."')";
				mysqli_query ($con,$sql);
				
            }
			echo $return;
        }
		
		/*
		if ($return=="true"){
			
			$sql="INSERT INTO user(userName, password, email) VALUES('".$userName."', '".$mdp."', '".$email."')";
			mysqli_query ($con,$sql)
			$return="true";				
			
		}
		//else $return="false";
       */
		
		

      /*  $code_aleatoire = genererCode();
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
		
       /* $um = new UserManager(connexionDb());
        $um->addUser($userToAdd);
        /**
         * Ici j'ai besoin de savoir quel est le user id du nouveau membre ajouté pour pouvoir le mettre dans l'ajout du code d'activation de cet user
         * Donc je vais le rechercher en base de donnée où il vient d'être ajouté
         */
       
/*	   $user = $um->getUserByUserName($userToAdd->getUserName());

        $userid = $user->getId();
        /**
         * J'ajoute le nouveau code d'activation à la BDD
         */
        
		
		/*$am = new ActivationManager(connexionDb());
        $activation = new Activation(array(
            "code" => $code_aleatoire,
            "id_user" => $userid,
            "libelle" => "Inscription",
            ));
        $am->addActivation($activation);
*/
   ?>
