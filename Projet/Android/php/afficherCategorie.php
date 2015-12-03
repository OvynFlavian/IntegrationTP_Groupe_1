<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$sql = "select id, libelle from categorie";
	$res = mysqli_query($con, $sql);
	
	$i = 1;
	while($row = mysqli_fetch_array($res)) {
		$j = strval($i);
		$retour[$j] = $row['libelle'];
		$i++;
	}
	
	$retour[strval(0)] = $i;
	
	echo json_encode($retour);
	
?>