<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$tb= $_POST['userName'];
	$id= $_POST['id'];
	
	$i=16;
	$username="";
	
	while ($tb[$i+1]!="D" or $tb[$i+2]!="e" or $tb[$i+3]!="s" or $tb[$i+4]!="c" or $tb[$i+5]!="r" or $tb[$i+6]!="i"or $tb[$i+7]!="p" or $tb[$i+8]!="t"){		
		$username=$username.$tb[$i];
		$i++;
	}		
		
	$i=0;

	$sql = "select * from user where UserName = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];	

	
	$sql2 = "select * from groupe where id_leader ='".$userId."' ";

	$query2 = mysqli_query($con,$sql2);
	$row2 = mysqli_fetch_assoc($query2);
	$idGroupe = $row2['id_groupe'];	
	
	
	$sql9 = "select * from groupe where id_leader ='".$id."' ";

	if(mysqli_query($con,$sql9)){
		$sql6="DELETE FROM `projetIntegration`.`groupe` WHERE `groupe`.`id_leader` = ".$id." ";
		$query6 = mysqli_query($con,$sql6);
	}
	
	
	$sql4 = "select * from groupe where id_user ='".$userId."' ";
	if(mysqli_query($con,$sql4)){
		$sql6="UPDATE user_groupe SET id_groupe='".$idGroupe."' ";
		$query6 = mysqli_query($con,$sql6);
	}
	else{
		$sql3="INSERT INTO user_groupe(id_groupe, id_user, date) VALUES('".$idGroupe."', '".$id."', NOW())";
		$query3 = mysqli_query($con,$sql3);
	}
	
	
	
	
	
	echo ($username);

		
?>
