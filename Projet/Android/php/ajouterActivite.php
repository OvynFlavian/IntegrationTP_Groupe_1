<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$titre = $_POST['titre'];
	$description = $_POST['description'];
	$categorie = $_POST['categorie'];
	$imagePresente = $_POST['imagePresente'];
	$idUser = $_POST['idUser'];
	
	$replace = array("'");  
	$titre = str_replace($replace, "\'", $titre);
	$description = str_replace($replace, "\'", $description);
	
	$retour['error'] = "FALSE";
	$retour['existe'] = "FALSE";
	$retour['champsVide'] = "FALSE";
	
	if ($titre != "" && $description != "" && $categorie != "") {
	
		$sql = "select id from activity where libelle = '".$titre."'";
		$res = mysqli_query($con, $sql);
		$existe = false;
		while ($row = mysqli_fetch_array($res)) {
			if ($row['id'] != null) {
				$existe = true;
			}
		}
	
		if (!$existe && $imagePresente == "true") {
			$sql = "select id from categorie where libelle = '".$categorie."'";
			$res = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($res);
			$idCat = $row['id'];
	
			$sql = "insert into activity (Libelle, description) values ('".$titre."', '".$description."')";
			$res = mysqli_query($con, $sql);
	
			$sql = "select id from activity where Libelle = '".$titre."'";
			$res = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($res);
			$idActivite = $row['id'];
	
			$sql = "insert into categorie_activity (id_categorie, id_activity, date) values ('".$idCat."', '".$idActivite."', NOW())";
			$res = mysqli_query($con, $sql);
			
			$sql = "select id from activity where Libelle = '".$titre."'";
			$res = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($res);
			$idActivite = $row['id'];
			$retour['idActivite'] = $idActivite;
			
			$sql = "update user set DateLastIdea = NOW() where id = '".$idUser."'";
		
			$retour['error'] = "FALSE";
		} else {
			$retour['error'] = "TRUE";
			$retour['existe'] = "TRUE";
		}
	} else {
		$retour['error'] = "TRUE";
		$retour['champsVide'] = "TRUE";
	}
	
	echo json_encode($retour);
	
?>