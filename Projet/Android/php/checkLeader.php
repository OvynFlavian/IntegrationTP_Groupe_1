<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	$idGroupe = $_POST['idGroupe'];	
	
	$sql = "select id_leader from groupe where id_groupe = '".$idGroupe."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	
	$retour['idLeader'] = $row['id_leader'];
	
	echo json_encode($retour);
?>