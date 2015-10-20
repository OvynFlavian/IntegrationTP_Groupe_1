<?php

  define('HOST','localhost');
  define('USER','root');
  define('PASS','LUCIENNE1223');
  define('DB','projetintegration');
  
 

$con = mysqli_connect(HOST,USER,PASS,DB);

	 //include 'fonction.php';
	 //probleme, il dis qu'il ne connait pas les fonction, qu'elles ne sont pas définies...
	 
        $return = "error";
        if(null !==$_POST['mdp'] OR null !==$_POST['mdpConfirm'])
		{
      
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
                if($validUserMail and $validUserName and $champValid and ($return== "true")){

					$sql="INSERT INTO user(userName, password, email) VALUES('".$userName."', '".$mdp."', '".$email."')";
					mysqli_query ($con,$sql);
				}
				
				
            }
			echo $return;
			
        }
		
		
		
		$query = mysqli_query($con,"select * from user where userName='".$userName."'");
		$row = mysqli_fetch_assoc($query);
		$userId = $row['id'];
		$userNameBdd = $row['userName'];
		$passwordBdd= $row['password'];
		$emailBdd= $row['email'];
		

		

        $code_aleatoire = genererCode();
        $adresseAdmin = "andrewblake@hotmail.fr";
        $to = $email;
        $sujet = "Confirmation de l'inscription";
        $entete = "From:" . $adresseAdmin . "\r\n";
        $message = "Nous confirmons que vous êtes officiellement inscrit sur le site EveryDayIdea <br>
									Votre login est : " . $userNameBdd . " <br>   
									Votre email est : " . $emailBdd . " <br>
									Votre lien d'activation est : <a href='www.everydayidea/activation.php?code=" . $code_aleatoire . "'>www.everydayidea/activation.php?code=" . $code_aleatoire . "</a>";
       // mail($to, $sujet, $message, $entete);
      //  echo "Votre inscription est dorénavant complète ! Un email vous a été envoyé avec vos informations et votre code d'activation !";
		
				$sql="INSERT INTO activation (id_user, code, date) VALUES('".$userId."', '".$code_aleatoire."', NOW())";
		mysqli_query ($con,$sql);



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
		
		function champsEmailValable($champ) {
			if(preg_match('#^[a-zA-Z0-9@._]*$#', $champ)) {
				return true;
			}
			else {
				return false;
			}
		}
		
		function champsLoginValable($champ) {
			if(preg_match('#^[a-zA-Z0-9 \ éàèîêâô! ]*$#', $champ)) {
				return true;
			}
			else {
			return false;
			}
		}

		function champsMdpValable($champ) {
			if(preg_match('#^[a-zA-Z0-9 \ éàèîêâô!? ]*$#', $champ)) {
           return true;
			}
			else {
			return false;
			}
		}
		
		function genererCode() {
			$characts    = 'abcdefghijklmnopqrstuvwxyz';
			$characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$characts   .= '1234567890';
			$code_aleatoire      = '';

			for($i=0;$i < 6;$i++){
				$code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
			}
			return $code_aleatoire;
		}
   ?>
