<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','totopipo007');
	define('DB','projet');

	$con = mysqli_connect(HOST,USER,PASS,DB);
	$id= $_POST['id'];
	
	$i=0;
	$response[$i]["error"]="TRUE";
	$sql = "select DISTINCT id, UserName, email from user t1, amis t2 where t1.public = 'TRUE' AND t1.id != ".$id." ORDER BY UserName ASC ";
	
	//$sql="SELECT DISTINCT id, email, userName FROM user A INNER JOIN amis B ON A.id=B.id_user_1 AND A.id<>".$id." AND B.id_user_1 <>".$id." AND B.id_user_2 <>".$id."";
	
	//$sql="SELECT DISTINCT id, email, userName FROM user A INNER JOIN amis B ON A.id = B.id_user_1 AND A.id <>".$id." AND B.id_user_1 <>".$id." AND B.id_user_2 <>".$id." AND A.public='TRUE' ";

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

	// ne renvoie rien, surement une erreur dans la requete, verifier les "nom" des champs.	
		
?>
