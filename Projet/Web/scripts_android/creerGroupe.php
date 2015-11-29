<?php
	
  define('HOST','localhost');
  define('USER','root');
  define('PASS','poulet77');
  define('DB','projetIntegration');
  

	$con = mysqli_connect(HOST,USER,PASS,DB);

	
	$id= $_POST['id'];
	$desc= $_POST['desc'];

	$sql = "select * from user where id = '".$id."' ";
	$query = mysqli_query($con,$sql);
	
	
	$sql4 = "select * from user_activity where id_User = '".$id."' ";
	$query4 = mysqli_query($con,$sql4);
	$row = mysqli_fetch_assoc($query4);
	$idActi = $row['id_activity'];
	
	$sql3="INSERT INTO groupe( id_leader , date, description, id_activity) VALUES('".$id."', NOW(),'".$desc."','".$idActi."' )";
	$query3 = mysqli_query($con,$sql3);
	

	
	echo ($desc);
	

		
?>
