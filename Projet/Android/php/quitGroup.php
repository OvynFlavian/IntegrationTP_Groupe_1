<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$id = $_POST['id'];	
	$username = $_POST['userName'];
	
	$i=0;

	$sql = "select * from groupe where description = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idGroupe = $row['id_groupe'];	
	$id_leader = $row['id_leader'];
	
	
	$sql9 = "select * from groupe where id_leader ='".$id."' ";

	if(mysqli_query($con,$sql9)){
		
			$sql = "select id_user from user_groupe where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$idNewLeader = $row['id_user'];
	
	$sql = "update groupe set id_leader = '".$idNewLeader."' where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	
		$sql6="DELETE FROM `projetIntegration`.`groupe` WHERE `groupe`.`id_leader` = ".$id." ";
		$query6 = mysqli_query($con,$sql6);
	}
	
	
	$sql4 = "select * from groupe where id_user ='".$id."' ";
	if(mysqli_query($con,$sql4)){
		$sql6="delete from user_groupe where id_user='".$id."' ";
		$query6 = mysqli_query($con,$sql6);
	}

echo $username;
?>