<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$id= $_POST['id'];
	
	$i=0;

	$sql = "SELECT * FROM `user` WHERE id not in (select id_user_2 from amis where id_user_1=".$id." ) and id not in (select id_user_1 from amis where id_user_2=".$id.") and id !=".$id." ";
	
//	$sql = "select * from user where id !=".$id." ORDER BY UserName ASC";

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
