<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  

	$con = mysqli_connect(HOST,USER,PASS,DB);

	
	$id= $_POST['id'];

	$sql = "select * from user where id = '".$id."' ";
	$query = mysqli_query($con,$sql);
	
	
		$sql5 = "select * from user_groupe where id_user = '".$id."' ";
	$query5 = mysqli_query($con,$sql5);
	$row = mysqli_fetch_assoc($query5);
	$idGroupe = $row['id_groupe'];
	
	
	$sql7="DELETE FROM `projetIntegration`.`user_groupe` WHERE `user_groupe`.`id_user` = ".$id." ";
	$query7 = mysqli_query($con,$sql7);
	
	
		$sql = "select id_user from user_groupe where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$idNewLeader = $row['id_user'];
	
	$sql = "update groupe set id_leader = '".$idNewLeader."' where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	
	$sql6="DELETE FROM `projetIntegration`.`groupe` WHERE `groupe`.`id_leader` = ".$id." ";
	$query6 = mysqli_query($con,$sql6);
		
	echo ($id);
	

		
?>
