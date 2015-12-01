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
	
	while ($tb[$i+1]!="D" or $tb[$i+2]!="e" or $tb[$i+3]!="s" or $tb[$i+4]!="c" or $tb[$i+5]!="r" or $tb[$i+6]!="i"or $tb[$i+7]!="p" or $tb[$i+8]!="t"){		
		$username=$username.$tb[$i];
		$i++;
	}		
		

	$sql = "select * from user where UserName = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];


	//$sql="INSERT INTO amis(id_user_1, id_user_2, date, accepte) VALUES('".$id."', '".$userId."', NOW(), '1')";
	$sql="DELETE FROM `projetIntegration`.`groupe_invitation` WHERE `groupe_invitation`.`id_user_demande` = ".$id." AND `groupe_invitation`.`id_user_envoi` = ".$userId." ";
	
	
	$query = mysqli_query($con,$sql);
	
	echo $userId;

		
?>
