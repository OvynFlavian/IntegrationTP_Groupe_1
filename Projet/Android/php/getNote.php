<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');
	
	function roundTo($number, $to){ 
		return round($number/$to, 0)* $to; 
	}

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$libelle = $_POST['libelle'];
	
	$sql = "select id, note, description from activity where Libelle = '".$libelle."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$retour['description'] = $row['description'];
	$br = array("<br />","<br>","<br/>");  
	$retour['description'] = str_replace($br, "", $retour['description']);
	if ($row['note'] == null) {
		$retour['note'] = "99";
	} else {
		$retour['note'] = roundTo($tbActivity[$idx]['note'], .5);
	}
	$id = $row['id'];
	$sql = "select libelle from categorie where id in (select id_categorie from categorie_activity where id_activity = '".$id."')";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	
	$retour['categorie'] = $row['libelle'];
	$retour['idActivite'] = $id;
	
	echo json_encode($retour);
	
	
?>