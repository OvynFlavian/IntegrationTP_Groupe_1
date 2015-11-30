<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$tb= $_POST['userName'];
	$id= $_POST['id'];
	
	$i=19;
	$username="";
	
	while (($tb[$i+1]!="E" or $tb[$i+2]!="m" or $tb[$i+3]!="a" or $tb[$i+4]!="i" or $tb[$i+5]!="l" or $tb[$i+6]!=":")){		
		$username=$username.$tb[$i];
		$i++;
	}	
		
	$i=0;

	$sql = "select * from user where UserName = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];	

	
	$sql2 = "select * from user_groupe where id_user ='".$id."' ";

	$query2 = mysqli_query($con,$sql2);
	$row2 = mysqli_fetch_assoc($query2);
	$idGroupe = $row2['id_groupe'];	
	

	$sql3="INSERT INTO groupe_invitation(id_user_demande, id_user_envoi, id_groupe, accepte) VALUES('".$userId."', '".$id."', '".$idGroupe."' ,'0')";
	
	$query3 = mysqli_query($con,$sql3);
	
	echo ($idGroupe);

		
?>
