<?php

  define('HOST','localhost');
  define('USER','root');
  define('PASS','LUCIENNE1223');
  define('DB','projetintegration');
  
 

$con = mysqli_connect(HOST,USER,PASS,DB);

	 //include 'fonction.php';
	 //probleme, il dis qu'il ne connait pas les fonction, qu'elles ne sont pas définies...
	 
        $return = "error";
       // if(isset($_POST['mdp'] == $_POST['mdpConfirm'])
        if(1==1)
		{
            //$ini = getConfigFile();
            $userName = strtolower($_POST['userName']);
            $mdp = $_POST['mdp'];
			$mdpConf = $_POST['mdpConfirm'];
            $email = $_POST['email'];
			$return= "true";

            if(strlen($userName) < 6)
                $return= "Votre nom d'utilisateur est trop court, 6 caractères minimum ! <br>";

            if(strlen($mdp) < 5)
                $return .="Votre mot de passe est trop court, 5 caractères minimum ! <br>";
			if($mdp!=$mdpConf)
				$return .="Vos mots de passes sont différents ! <br>";
            else
            {
                //$um = new UserManager(connexionDb());
                //$tabUser = getAllUser();
                $validUserName = true;
                $validUserMail = true;
                $champValid = true;
             
				if (nbUserByUsername($userName)>0)
                        $validUserName = false;
				if (nbUserByEmail($email)>0)
                        $validUserMail = false;
					
                
                if(!$validUserMail)
                    $return .= "Cette adresse mail est déjà utilisée, veuillez en choisir une autre ! <br>";
                if(!$validUserName)
                    $return .= "Ce login est déjà pris, veuillez en choisir en autre ! <br>";
				/*
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
                  */ 
			  
				if($return== "true"){
			  
					$sql="INSERT INTO user(userName, password, email) VALUES('".$userName."', '".$mdp."', '".$email."')";
					mysqli_query ($con,$sql);
				}
				
            }
			echo $return;
			
        }
		
		function nbUserByUsername($userName){	
			$con = mysqli_connect(HOST,USER,PASS,DB);
			$query="SELECT * FROM user WHERE userName ='".$userName."' ";
			if($result=mysqli_query($con,$query)){
				$nbResult=mysqli_num_rows($result);
				return $nbResult;		
		
			}
		}
		
		
		function nbUserByEmail($email){
			$con = mysqli_connect(HOST,USER,PASS,DB);
			$query="SELECT * FROM user WHERE email = '".$email."'";
			if($result=mysqli_query($con,$query)){
				$nbResult=mysqli_num_rows($result);
				return $nbResult;		
			}
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
