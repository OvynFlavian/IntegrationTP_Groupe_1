<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  
	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];
	$i=0;
	$response[$i]["error"]="TRUE";

	$sql = "select * from message where id_user_source='".$id."'  ";

	$query = mysqli_query($con,$sql);
	
	

	while($row = mysqli_fetch_assoc($query)){
		
		if ($row['id_user_source']== $id){
			$userId = $row['id_user_1'];
			$sql2 = "select * from user where id = '".$userId."' ";
			$query2 = mysqli_query($con,$sql2);
			$row2=mysqli_fetch_assoc($query2);
			$userNameBdd = $row2['UserName'];
			$emailBdd= $row2['email'];
		
			if($userId!=NULL) {
				$response[$i]["error"] ="FALSE";
				$response[$i]["userName"]= $userNameBdd;
				$response[$i]["email"]= $emailBdd;
			}	
		
			$i++;
		}
		if ($row['id_user_dest']== $id){
			$userId = $row['id_user_2'];
			$sql2 = "select * from user where id = '".$userId."' ";
			$query2 = mysqli_query($con,$sql2);
			$row2=mysqli_fetch_assoc($query2);
			$userNameBdd = $row2['UserName'];
			$emailBdd= $row2['email'];
		
			if($userId!=NULL) {
				$response[$i]["error"] ="FALSE";
				$response[$i]["userName"]= $userNameBdd;
				$response[$i]["email"]= $emailBdd;
			}	
		
			$i++;
			
			
		}
		
		
	}	
        
	echo json_encode($response);
	
	// ne renvoie rien, surement une erreur dans la requete, verifier les "nom" des champs.

		
?>
