<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$categorie = $_POST['categorie'];
	
	$sql = "select libelle from categorie";
	$res = mysqli_query($con, $sql);
	$i = 0;
	while ($row = mysqli_fetch_array($res)) {
		$j = strval($i+1);
		$retour[$j] = $row['libelle'];
		$i++;
	}
	
	$retour['0'] = $i;
	
	echo json_encode($retour);
	
	
?>