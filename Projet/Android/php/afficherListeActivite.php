<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$categorie = $_POST['categorie'];
	
	$sql = "select Libelle, description, note from activity where id in (select id_activity from categorie_activity where id_categorie in ( select id from categorie where libelle = '".$categorie."'))";
	$res = mysqli_query($con, $sql);
	
	$i = 0;
	while ($row = mysqli_fetch_array($res)) {
		$retour[$i]['libelle'] = $row['Libelle'];
		$retour[$i]['description'] = $row['description'];
		$br = array("<br />","<br>","<br/>");  
		$retour[$i]['description'] = str_replace($br, "", $retour[$i]['description']);
		$br = array("\n");  
		$retour[$i]['description'] = str_replace($br, " ", $retour[$i]['description']);
		$retour[$i]['description'] = substr($retour[$i]['description'], 0, 50)."...";
		$i++;
	}
	
	echo json_encode($retour);
	
	
?>