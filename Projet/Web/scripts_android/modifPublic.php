<?php

  define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');
  
	$isCheck = "0";

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$isCheck = "1";
	
	$isCheck = $_POST['isCheck'];
	$id=$_POST['id'];
	
	
	
	
	$sql="UPDATE user SET public='".$isCheck."' WHERE id='".$id."' ";
	mysqli_query ($con,$sql);
	
						
	echo $isCheck;


	
?>