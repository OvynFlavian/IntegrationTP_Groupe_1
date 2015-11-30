<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);

	$tb= $_POST['userName'];
	$id= $_POST['id'];
	
	//il n' pas l'air de meme trouver le POST...
	
	 
	$i=19;
	$username="";
	
	while ($tb[$i+1]!="D" or $tb[$i+2]!="e" or $tb[$i+3]!="s" or $tb[$i+4]!="c" or $tb[$i+5]!="r" or $tb[$i+6]!="i"or $tb[$i+7]!="p" or $tb[$i+8]!="t"){		
		$username=$username.$tb[$i];
		$i++;
	}		
		

	$sql = "select * from user where UserName = '".$username."' ";

	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($query);
	$userId = $row['id'];

	$sql2="DELETE FROM groupe_invitation WHERE id_user_demande = ".$id." AND id_user_envoi= ".$userId." ";
	
	$query2 = mysqli_query($con,$sql2);
	
	echo $userId;

		
?>
