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


	//$sql="INSERT INTO amis(id_user_1, id_user_2, date, accepte) VALUES('".$id."', '".$userId."', NOW(), '1')";
	$sql="DELETE FROM `projetIntegration`.`amis` WHERE `amis`.`id_user_1` = ".$id." AND `amis`.`id_user_2` = ".$userId." OR  `amis`.`id_user_1` = ".$userId." AND `amis`.`id_user_2` = ".$id." ";
	
	
	$query = mysqli_query($con,$sql);
	
	echo $username;

		
?>
