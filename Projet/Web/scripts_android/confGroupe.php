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
	
	while (($tb[$i+1]!="D" or $tb[$i+2]!="e" or $tb[$i+3]!="s" or $tb[$i+4]!="c" or $tb[$i+5]!="r" or $tb[$i+6]!="i"or $tb[$i+7]!="p"or $tb[$i+8]!="t")){		
		$username=$username.$tb[$i];
		$i++;
	}		
	
		
	$userId="null";
	$sql = "select * from user where UserName = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];


	$sql="UPDATE groupe_invitation SET accepte='1' WHERE ((id_user_demande = '".$id."' AND id_user_envoi = '".$userId."') ) ";

	$query = mysqli_query($con,$sql);
	
	
	$sql = "select * from groupe_invitation WHERE (id_user_demande = '".$id."' AND id_user_envoi = '".$userId."' AND accepte='1') ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idGroupe = $row['id_groupe'];
	
	
	

	$sql3="INSERT INTO user_groupe( id_groupe , id_user, date) VALUES('".$idGroupe."','".$id."', NOW() )";
	$query3 = mysqli_query($con,$sql3);
	
	
	
	echo $idGroupe;

		
?>
