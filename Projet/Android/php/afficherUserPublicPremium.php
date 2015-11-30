<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);
$id= $_POST['id'];

	
	$i=0;

	//$sql = "SELECT distinct `id`,`UserName`,email FROM user, user_droit WHERE public = 'TRUE' AND id_Droits<4 ORDER BY UserName DESC" ;
	
	//$sql = "SELECT distinct `id`,`UserName`,email FROM user, user_droit WHERE id not in (SELECT id_user FROM `user_groupe` WHERE id_groupe in (select id_groupe from user_groupe where id_user=".$id.")) and id !=".$id." AND id_Droits<4 ORDER BY UserName ASC";

	
	
	$sql="SELECT distinct `id`,`UserName`,email FROM user, user_droit WHERE 
		id not in (SELECT id_user FROM `user_groupe` WHERE id_groupe in (select id_groupe from user_groupe where id_user=".$id.") ) 
		and id in (select id_user from user_activity where id_activity in (select id_activity from groupe where id_groupe in (select id_groupe from user_groupe where id_user=".$id.")))AND id_Droits<4 ORDER BY UserName ASC";
		
	$query = mysqli_query($con,$sql);
	
	if ($query==false){
		$sql="SELECT * FROM user WHERE id in (select id_User from user_droit where id_Droits<4) ORDER BY UserName ASC" ;
		
	$query = mysqli_query($con,$sql);
	}
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
