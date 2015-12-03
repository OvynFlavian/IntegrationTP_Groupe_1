<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$userId = $_POST['userId'];
	
	$sql = "select id, Libelle, description from activity where id in (select id_activity from user_activity where id_User = '".$userId."')";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	
	if ($row['Libelle'] != null) {
		$retour['error'] = false;
		$retour['activite'] = $row['Libelle'];
		$retour['description'] = $row['description'];
		$retour['id'] = $row['id'];
	} else {
		$retour['error'] = true;
		$retour['activite'] = "null";
		$retour['description'] = "null";
		$retour['id'] = "null";
	}
	
	echo json_encode($retour);
	
	
?>