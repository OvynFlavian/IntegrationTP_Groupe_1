<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','totopipo007');
	define('DB','projet');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$idUser = $_POST['idUser'];
	$idActivite = $_POST['idActivite'];
	
	$sql = "update user_activity set id_activity = '".$idActivite."', date = NOW() where id_User = '".$idUser."'";
	$res = mysqli_query($con, $sql);
	
	
?>