<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	$idGroupe = $_POST['idGroupe'];	
	$userName = $_POST['userName'];
	
	$message = "L\'utilisateur $userName a quitté le groupe suite à un changement d\'activité.";
	$sql = "insert into groupe_message (id_groupe, id_user, description, date) values ('".$idGroupe."', '".$idUser."', '".$message."', NOW())";
	$res = mysqli_query($con, $sql);
	
	$sql = "delete from user_groupe where id_user = '".$idUser."'";
	$res = mysqli_query($con, $sql);
	
	$sql = "select id_user from user_groupe where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$idNewLeader = $row['id_user'];
	
	$sql = "update groupe set id_leader = '".$idNewLeader."' where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);

?>