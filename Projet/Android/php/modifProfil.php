<?php

	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');
	
	//echo "$ post mdp : " + $_POST['mdp'];
  
	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	
	
	$userName = strtolower($_POST['userName']);
	$email = $_POST['email'];
	$mdp = $_POST['mdp'];
	$mdpConf = $_POST['mdpConf'];
	$mdpOld = $_POST['mdpOld'];
	$id = $_POST['userId'];
	$tel = $_POST['tel'];
	
	$return= "erreur.";
	
    if($mdpOld != "") {
			
		$query = mysqli_query($con,"select * from user where id = '".$id."'");
		$row = mysqli_fetch_array($query);
		$userId = $row['id'];
		$userNameOld = $row['UserName'];
		$emailOld = $row['email'];
		$salt = $row['salt'];
		
		$mdpOld = hash("sha256", $mdpOld.$salt);
		
		$mdpBdd = $row['Mdp'];
		
		if($mdpOld != $row['Mdp']) {
			$return .= "Votre ancien mot de passe est incorrect";
		} else {
			
			if(strlen($userName) < 6)
				$return .= "Votre nom d'utilisateur est trop court, 6 caracteres minimum ! ";

			if($mdp != "" && $mdp != null && strlen($mdp) < 5)
				$return .= "Votre mot de passe est trop court, 5 caracteres minimum ! ";
				
			if($mdp != "" && $mdp != null && $mdpConf != "" && $mdpConf != null && $mdp != $mdpConf)
				$return .="Vos mots de passes sont differents ! ";
				
			else {

				$validUserName = true;
				$validUserMail = true;
				$champValid = true;
				 
				if (nbUserByUsername($userName) > 0 && ($userName != $userNameOld))
					$validUserName = false;
					
				if (nbUserByEmail($email) > 0 && ($email !=$emailOld))
					$validUserMail = false;
						
				if(!$validUserMail)
					$return .= "Cette adresse mail est deja utilisee, veuillez en choisir une autre ! ";
					
				if(!$validUserName)
					$return .= "Ce login est deja pris, veuillez en choisir en autre ! ";
					
				if(!champsEmailValable($email)) {
					$return .= "Votre adresse mail contient des caracteres indesirables !";
					$champValid = false;
				}
					
				if (!champsLoginValable($userName)){
					$return .= "Votre nom d'utilisateur contient des caracteres indesirables !";
					$champValid = false;
				}
				
				if (!champsMdpValable($mdp)) {
					$return .= "Votre mot de passe contient des caracteres indesirables !";
					$champValid = false;
				}
			
				if($validUserMail and $validUserName and $champValid and ($return == "erreur.") ){
					$mdp= hash("sha256", $mdp.$salt);
					if($_POST['mdp'] == "") {
						$mdp = $mdpBdd;
					}
					$sql="UPDATE user SET UserName='".$userName."', Mdp = '".$mdp."' , email='".$email."', tel = '".$tel."' WHERE id='".$userId."' ";
					mysqli_query ($con,$sql);
				}
			}
		}
    } else {
		$return .= "Vous devez remplir votre ancien mot de passe";
	}
		
	echo $return;


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
		
	
   ?>
