<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$userName = $_POST['userName'];
	$idActivite = $_POST['idActivite'];
	$idUser = $_POST['idUser'];
	$idGroupe = $_POST['idGroupe'];
	$dansGroupe = $_POST['dansGroupe'];
	$isLeader = $_POST['isLeader'];
	$isSeul = $_POST['isSeul'];
	$note = floatval($_POST['note']);
	
	$sql = "select note, votants from activity where id = '".$idActivite."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	
	$noteBdd = $row['note'];
	$votants = $row['votants'];
	
	$noteBdd = (($noteBdd * $votants) + $note) / ($votants + 1);
	$votants = $votants + 1;

	$sql = "update activity set note = '".$noteBdd."', votants = '".$votants."' where id = '".$idActivite."'";
	$res = mysqli_query($con, $sql);
	
	if ($dansGroupe == "true" && $isLeader == "true" && $isSeul == "false") {
		$message = "L\'utilisateur $userName a quitté le groupe suite à un changement d\'activité.";
		$sql = "insert into groupe_message (id_groupe, id_user, description, date) values ('".$idGroupe."', '".$idUser."', '".$message."', NOW())";
		$res = mysqli_query($con, $sql);
		
		$sql = "delete from user_groupe where id_user = '".$idUser."'";
		$res = mysqli_query($con, $sql);
		
		$sql = "select id_user from user_groupe where id_groupe = '".$idGroupe."'";
		$res = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($res);
		$idNewLeader = $row['id_user'];
		
		$sql = "update groupe set id_leader = '".$idNewLeader."' where id_groupe = '".$idGroupe."'";
		$res = mysqli_query($con, $sql);
	}
	
	if ($dansGroupe == "true" && $isSeul == "true") {
		$sql = "delete from groupe_message where id_groupe = '".$idGroupe."'";
		$res = mysqli_query($con, $sql);
		
		$sql = "delete from groupe_invitation where id_groupe = '".$idGroupe."'";
		$res = mysqli_query($con, $sql);
		
		$sql = "delete from user_groupe where id_groupe = '".$idGroupe."'";
		$res = mysqli_query($con, $sql);
		
		$sql = "delete from groupe where id_groupe = '".$idGroupe."'";
		$res = mysqli_query($con, $sql);
	}
	
	if ($dansGroupe == "true" && $isSeul == "false" && $isLeader == "false") {
		$message = "L\'utilisateur $userName a quitté le groupe suite à un changement d\'activité.";
		$sql = "insert into groupe_message (id_groupe, id_user, description, date) values ('".$idGroupe."', '".$idUser."', '".$message."', NOW())";
		$res = mysqli_query($con, $sql);
		
		$sql = "delete from user_groupe where id_user = '".$idUser."'";
		$res = mysqli_query($con, $sql);
	}
	
	$sql = "delete from user_activity where id_User = '".$idUser."'";
	$res = mysqli_query($con, $sql);
	
?>