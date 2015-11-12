<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','totopipo007');
	define('DB','projet');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];


	$sql = "select * from amis where id_user_1 = '".$id."' ";

	$query = mysqli_query($con,$sql);
	
	$i=0;
	while($row = mysqli_fetch_assoc($query)){
		$userId = $row['id_user_2'];
		$sql2 = "select * from user where id = '".$userId."' ";
		$query2 = mysqli_query($con,$sql2);
		$row2=mysqli_fetch_assoc($query2);
		$userNameBdd = $row2['UserName'];
		$emailBdd= $row2['email'];
		
		
		if($userId!=NULL) {
			$response[$i]["error"] ="FALSE";
			$response[$i]["userName"]= $userNameBdd;
			$response[$i]["email"]= $emailBdd;
				
		
		}	
		
		$i++;
	}	
        
	echo json_encode($response);

		
?>
