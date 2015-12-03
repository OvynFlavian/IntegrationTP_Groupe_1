<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$userID = $_POST['userId'];
	
	$sql = "select Libelle from activity where id in (select id_activity from user_activity where id_User = '".$userId."')";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res)
	
	$retour['activite'] = $row['Libelle'];
	
	echo json_encode($retour);
	
	
?>