<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];


	$sql = "select * from groupe where id_activity in (select id_activity from user_activity where id_User='".$id."')";

	$query = mysqli_query($con,$sql);
	
	$i=0;
	while($row = mysqli_fetch_assoc($query)){
		
		$userId = $row['id_leader'];
		$desc= $row['description'];
		$sql2 = "select * from user where id = '".$userId."'  ";
		$query2 = mysqli_query($con,$sql2);
		$row2=mysqli_fetch_assoc($query2);
		$userNameBdd = $row2['UserName'];
		
		
		
		if($userId!=NULL) {
			$response[$i]["error"] ="FALSE";
			$response[$i]["userName"]= $userNameBdd;
			$response[$i]["description"]= $desc;
				
		
		}	
		
		$i++;
	}	
        
	echo json_encode($response);

		
?>
