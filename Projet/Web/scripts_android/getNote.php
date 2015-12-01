<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$libelle = $_POST['libelle'];
	
	$sql = "select id, note from activity where Libelle = '".$libelle."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	if (isset($row['note'])) {
		$retour['note'] = $row['note'];
	} else {
		$retour['note'] = "99";
	}
	$id = $row['id'];
	$sql = "select libelle from categorie where id in (select id_categorie from categorie_activity where id_activity = '".$id."')";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	
	$retour['categorie'] = $row['libelle'];
	$retour['idActivite'] = $id;
	
	echo json_encode($retour);
	
	
?>