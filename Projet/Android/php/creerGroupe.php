<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  

	$con = mysqli_connect(HOST,USER,PASS,DB);

	
	$id= $_POST['id'];
	$desc= $_POST['desc'];

	$sql = "select * from user where id = '".$id."' ";
	$query = mysqli_query($con,$sql);
	
	
	$sql4 = "select * from user_activity where id_User = '".$id."' ";
	$query4 = mysqli_query($con,$sql4);
	$row = mysqli_fetch_assoc($query4);
	$idActi = $row['id_activity'];
	
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
	

	
	
	$sql3="INSERT INTO groupe( id_leader , date, description, id_activity) VALUES('".$id."', NOW(),'".$desc."','".$idActi."' )";
	$query3 = mysqli_query($con,$sql3);
	


	
	echo ($id);
	

		
?>
