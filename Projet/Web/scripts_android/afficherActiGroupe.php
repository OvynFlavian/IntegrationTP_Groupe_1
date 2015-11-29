<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  

	$con = mysqli_connect(HOST,USER,PASS,DB);

	
	$id= $_POST['id'];

	$sql="select * from user_activity where id_User = '".$id."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$idActi = $row['id_activity'];
	
	
	$sql="select * from activity where id = '".$idActi."' ";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$acti = $row['Libelle'];
	
	
	echo ($acti);
	

		
?>
