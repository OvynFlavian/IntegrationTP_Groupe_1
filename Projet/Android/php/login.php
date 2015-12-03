<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$username = $_POST['UserName'];
	$password = $_POST['Mdp'];
	$response["error"] = true;
	$response["id"] = "";
	$response["UserName"]= "";
	$response["Mdp"] = "";
	$response['dateInscription'] = "";
	$response['dateLastIdea'] = "";
	$response['tel'] = "";
	$response["email"]= "";
	$response['userDroit'] = "";
	$response['idDroit'] = 0;
	$response['dateLastConnect'] = "";
	
	$sql = "select * from user where UserName = '".$username."'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	
	if ($row == null) {
		$response['error'] = true;
	} else {
	
		$salt = $row['salt'];
		$mdp = $row['Mdp'];
		$password = hash("sha256", $password.$salt);

		$sql = "select * from user where UserName = '".$username."' AND Mdp = '".$password. "'";
		$query = mysqli_query($con,$sql);
		$row = mysqli_fetch_assoc($query);
		
		if($row != NULL){
			$response["error"] = false;
			$response["id"] = $row['id'];
			$userId = $row['id'];
			$response["UserName"]= $row['UserName'];
			$response["Mdp"] = $row['Mdp'];
			$response['dateInscription'] = $row['DateInscription'];
			$response['dateLastIdea'] = $row['DateLastIdea'];
			$response['tel'] = $row['tel'];
			$response["email"] = $row['email'];
			
			$sql = "select id, Libelle from droit where id in (select id_Droits from user_droit where id_User = '".$userId."')";
			$query = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($query);
			$userDroit = $row['Libelle'];
			$response['userDroit'] = $userDroit;
			$response['idDroit'] = $row['id'];
			
			$sql = "update user set DateLastConnect = NOW() where UserName = '".$userNameBdd."'";
			$query = mysqli_query($con, $sql);
			
			$sql = "select DateLastConnect from user where id = '".$userId."'";
			$query = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($query);
			
			$response['dateLastConnect'] = $row['DateLastConnect'];
			
		} else {
			$response['error'] = true;
		}
	
	}
	
	echo json_encode($response);
?>
