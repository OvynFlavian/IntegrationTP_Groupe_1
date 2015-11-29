<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$tb= $_POST['userName'];
	$id= $_POST['id'];
	
	$i=19;
	while ($tb[$i]!= '\\'){		
		$username=$tb[$i];
		$i++;
	}	
		
	$i=0;

	$sql = "select * from user where UserName = '".$userName."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];


	$sql="INSERT INTO amis(id_user_1, id_user_2, date) VALUES('".$id."', '".$userId."', NOW())";
	
	$query = mysqli_query($con,$sql);
	
	echo ($userId);

		
?>
