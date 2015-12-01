<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$id= $_POST['id'];



	
	$sql = "select * from groupe where id_leader = '".$id."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idGroupe=$row['id_groupe'];
	

	
	$sql2 = "INSERT INTO user_groupe (id_groupe , id_user , date) VALUES ('".$idGroupe."','".$id."', NOW() )";
	$query2 = mysqli_query($con,$sql2);
	
	
	echo $idGroupe;
	
	
		
?>
