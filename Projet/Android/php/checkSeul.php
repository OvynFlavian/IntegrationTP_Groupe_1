<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	$idGroupe = $_POST['idGroupe'];	
	
	$sql = "select id_user from user_groupe where id_groupe = $idGroupe";
	$res = mysqli_query($con, $sql);
	$i = 0;
	while ($row = mysqli_fetch_array($res)) {
		$i++;
	}
	
	$retour['nbUsers'] = $i;
	
	echo json_encode($retour);
?>