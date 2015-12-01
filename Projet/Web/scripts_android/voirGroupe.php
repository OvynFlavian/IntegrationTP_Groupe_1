<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  

	$con = mysqli_connect(HOST,USER,PASS,DB);

	
	$id= $_POST['id'];

	$sql="select * from user_groupe where id_user = '".$id."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idGroupe = $row['id_groupe'];
	
	
	$sql="select * from groupe where id_groupe = '".$idGroupe."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$desc = $row['description'];
	
	
	echo ($desc);
	

		
?>
