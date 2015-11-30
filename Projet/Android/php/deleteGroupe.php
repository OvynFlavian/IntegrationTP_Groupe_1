<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	$idGroupe = $_POST['idGroupe'];	
	$userName = $_POST['userName'];
	
	$sql = "delete from groupe_message where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	
	$sql = "delete from groupe_invitation where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	
	$sql = "delete from user_groupe where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	
	$sql = "delete from groupe where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);

?>