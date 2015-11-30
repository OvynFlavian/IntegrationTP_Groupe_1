<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');
  
	$con = mysqli_connect(HOST,USER,PASS,DB);

	$tb= $_POST['userName'];
	$id= $_POST['id'];
	
	//ajouter sécurité si amis déja amis ou en attente d'acceptation
	
	
	$i=19;
	$username="";
	
	while (($tb[$i+1]!="E" or $tb[$i+2]!="m" or $tb[$i+3]!="a" or $tb[$i+4]!="i" or $tb[$i+5]!="l" or $tb[$i+6]!=":")){		
		$username=$username.$tb[$i];
		$i++;
	}	
	
		
	$userId="null";
	$sql = "select * from user where UserName = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];
	$mail = $row['email'];
	
	$sql2 = "select * from user_activity where id_User = '".$userId."' ";

	$query2 = mysqli_query($con,$sql2);
	$row2 = mysqli_fetch_assoc($query2);
	$idActivity=$row2['id_activity'];
	
	$sql3 = "select * from activity where id = '".$idActivity."' ";
	
	$query3 = mysqli_query($con,$sql3);
	$row3 = mysqli_fetch_assoc($query3);
	$libelle=$row3['Libelle'];
	$description=$row3['description'];
	
	$sql4 = "select * from categorie_activity where id_activity = '".$idActivity."' ";
	
	$query4 = mysqli_query($con,$sql4);
	$row4 = mysqli_fetch_assoc($query4);
	$idCat=$row4['id_categorie'];
	
	$sql5 = "select * from categorie where id = '".$idCat."' ";
	
	$query5 = mysqli_query($con,$sql5);
	$row5 = mysqli_fetch_assoc($query5);
	$libCat=$row5['libelle'];
	
	
	
		if($userId!=NULL) {
			$i=0;
			$response[$i]["error"] ="FALSE";
			$response[$i]["userName"]= $username;
			$response[$i]["email"]= $mail;
			$response[$i]["libelle"]= $libelle;
			$response[$i]["idActivity"]= $idActivity;
			$response[$i]["idUser"]= $userId;
			$response[$i]["description"]= $description;
			$response[$i]["catLib"]= $libCat;
		}
		
		

	//$sql="DELETE FROM `projet`.`amis` WHERE `amis`.`id_user_1` = ".$id." AND `amis`.`id_user_2` = ".$userId." OR  `amis`.`id_user_1` = ".$userId." AND `amis`.`id_user_2` = ".$id." ";
	
	//$sql="INSERT INTO amis(id_user_1, id_user_2, date, accepte) VALUES('".$id."', '".$userId."', NOW(), '1')";
	
	//$query = mysqli_query($con,$sql);
	
	echo json_encode($response);

		
?>
