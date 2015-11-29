<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	$idActivite = $_POST['idActivite'];
	
	$sql = "select id_User from user_activity where id_User = '".$idUser."'";
	$res = mysqli_query($con,$sql);
	$user = mysqli_fetch_array($res);
	$retour['idUser'] = $user['id_User'];
	
	mysqli_free_result($res);
	
	if($retour['idUser'] == null) {
		$sql = "insert into user_activity(id_User, id_activity, date) values('".$idUser."', '".$idActivite."', NOW())";
		$res = mysqli_query($con, $sql);
	}
	
	echo json_encode($retour);

?>