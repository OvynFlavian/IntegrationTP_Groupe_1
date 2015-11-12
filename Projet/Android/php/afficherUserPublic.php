<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','totopipo007');
	define('DB','projet');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	
	$i=0;

	$sql = "select * from user where public = 'TRUE' ORDER BY UserName DESC";

	$query = mysqli_query($con,$sql);
	
	while($row = mysqli_fetch_assoc($query)){
		$userId = $row['id'];

		$userNameBdd = $row['UserName'];
		$emailBdd= $row['email'];
		
		
		if($userId!=NULL) {
			$response[$i]["error"] ="FALSE";
			$response[$i]["userName"]= $userNameBdd;
			$response[$i]["email"]= $emailBdd;
				
		
		}	
		
		$i++;
	}	
        
	echo json_encode($response);

		
?>
