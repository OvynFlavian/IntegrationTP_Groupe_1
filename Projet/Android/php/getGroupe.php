<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	
	$sql = "select id_groupe from user_groupe where id_user = '".$idUser."'";
	$res = mysqli_query($con, $sql);
	
	if ($row = mysqli_fetch_array($res)) {
		$retour['idGroupe'] = $row['id_groupe'];
	} else {
		$retour['idGroupe'] = 0;
	}
	
	echo json_encode($retour);
?>