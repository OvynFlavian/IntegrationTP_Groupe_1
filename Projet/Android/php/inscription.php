<?php

	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');
  
 

	$con = mysqli_connect(HOST,USER,PASS,DB);

	 
    $return = "error";
    if(null !==$_POST['mdp'] OR null !==$_POST['mdpConfirm']){
      
    $userName = strtolower($_POST['userName']);
			
			$mdp = $_POST['mdp'];
			$mdpConf = $_POST['mdpConfirm'];
			
			
            $email = $_POST['email'];
			$return= "erreur.";
            if(strlen($userName) < 6)
                $return= "Votre nom d'utilisateur est trop court, 6 caracteres minimum ! ";

            if(strlen($mdp) < 5)
                $return .="Votre mot de passe est trop court, 5 caracteres minimum ! ";
			if($mdp!=$mdpConf)
				$return .="Vos mots de passes sont differents ! ";
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
                    $return .= "Cette adresse mail est deja utilisee, veuillez en choisir une autre ! ";
                if(!$validUserName)
                    $return .= "Ce login est deja pris, veuillez en choisir en autre ! ";
				
                if(!champsEmailValable($email))
                {
                    $return .= "Votre adresse mail contient des caracteres indesirables !";
                    $champValid = false;
                }
				
                if (!champsLoginValable($userName))
                {
                    $return .= "Votre nom d'utilisateur contient des caracteres indesirables !";
                    $champValid = false;
                }
                if (!champsMdpValable($mdp))
                {
                    $return .= "Votre mot de passe contient des caracteres indesirables !";
                    $champValid = false;
                }
                if($validUserMail and $validUserName and $champValid and ($return=="erreur.") ){

					$salt = uniqid(mt_rand(), true);
					$mdp= hash("sha256", $mdp.$salt);
					$sql="INSERT INTO user(UserName, Mdp, email, DateInscription, DateLastConnect, salt) VALUES('".$userName."', '".$mdp."', '".$email."', NOW(), NOW(), '".$salt."')";
					mysqli_query ($con,$sql);
					
					
					
					$query = mysqli_query($con,"select * from user where UserName='".$userName."'");
					$row = mysqli_fetch_assoc($query);
					$userId = $row['id'];
					$userNameBdd = $row['UserName'];
					$passwordBdd= $row['Mdp'];
					$emailBdd= $row['email'];
					
					$sql = "insert into user_droit (id_Droits, id_User, Date) values (4, $userId, NOW())";
					mysqli_query ($con,$sql);
		
					$code_aleatoire = genererCode();
					$adresseAdmin = "andrewblake@hotmail.fr";
					$to = $email;
					$sujet = "Confirmation de l'inscription";
					$entete = "From:" . $adresseAdmin . "\r\n";
					$entete .= "Content-Type: text/html; charset=utf-8\r\n";
					$message = "Nous confirmons que vous êtes officiellement inscrit sur le site EveryDayIdea <br>
									Votre login est : " . $userNameBdd . " <br>   
									Votre email est : " . $emailBdd . " <br>
									Votre lien d'activation est : <a href='http://www.everydayidea.be/Page/activationInscription.page.php?code=" . $code_aleatoire . "'>Cliquez ici.</a>";
					mail($to, $sujet, $message, $entete);
		
					$sql="INSERT INTO activation (id_user, code, date, libelle) VALUES('".$userId."', '".$code_aleatoire."', NOW(), 'inscription')";
					mysqli_query ($con,$sql);
				}
            }
			echo $return;
        }

function nbUserByUsername($userName){	
			$con = mysqli_connect(HOST,USER,PASS,DB);
			$query="SELECT * FROM user WHERE UserName ='".$userName."' ";
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
