<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];


	$sql = "select * from user_groupe where id_user = '".$id."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idGroupe = $row['id_groupe'];
	
	$sql2 = "select * from user_groupe where id_groupe = '".$idGroupe."' ";
	$query2 = mysqli_query($con,$sql2);
	
	$i=0;
	while($row2 = mysqli_fetch_assoc($query2)){
		$userId = $row2['id_user'];
		
		$sql3 = "select * from user where id = '".$userId."' ";
		$query3 = mysqli_query($con,$sql3);
		$row3=mysqli_fetch_assoc($query3);
		$userNameBdd = $row3['UserName'];
		$emailBdd= $row3['email'];
		
		
		if($userId!=NULL and $userId!=$id) {
			$response[$i]["error"] ="FALSE";
			$response[$i]["userName"]= $userNameBdd;
			$response[$i]["email"]= $emailBdd;
				
		
		}	
		
		$i++;
	}	
        
	echo json_encode($response);

		
?>
