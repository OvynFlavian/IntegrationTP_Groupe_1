<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];
	$desc= $_POST['desc'];

	$sql = "select * from user_groupe where id_user = '".$id."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idGroupe = $row['id_groupe'];
	
	$sql2 = "INSERT INTO groupe_message (id_groupe, id_user, description, date) VALUES  ('".$idGroupe."', '".$id."','".$desc."',NOW() )";
	$query = mysqli_query($con,$sql2);


	
	echo $desc;
		
?>
