<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$username = $_POST['UserName'];
	$password = $_POST['Mdp'];
	$password= hash("sha256", $password);
	$userId=NULL;
	$response["error"] ="erreur";

	$sql = "select * from user where UserName = '".$username."' AND Mdp = '".$password. "'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	
	$userId = $row['id'];
	$userNameBdd = $row['UserName'];
	$passwordBdd= $row['Mdp'];
	$dateInscription = $row['DateInscription'];
	$dateLastIdea = $row ['DateLastIdea'];
	$tel = $row['tel'];
	$emailBdd= $row['email'];
	
	if($userId != NULL){
		$response["error"] ="FALSE";
		$response["id"] = $userId;
		$response["UserName"]= $userNameBdd;
		$response["Mdp"] = $passwordBdd;
		$response['dateInscription'] = $dateInscription;
		$response['dateLastIdea'] = $dateLastIdea;
		$response['tel'] = $tel;
		$response["email"]= $emailBdd;
		
		$sql = "select Libelle from droit where id in (select id_Droits from user_droit where id_User = '".$userId."')";
		$query = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($query);
		$userDroit = $row['Libelle'];
		$response['userDroit'] = $userDroit;
		
		$sql = "update user set DateLastConnect = NOW() where UserName = '".$userNameBdd."'";
		$query = mysqli_query($con, $sql);
       
		echo json_encode($response);
	}
		
?>
