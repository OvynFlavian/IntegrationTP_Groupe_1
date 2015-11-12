<?php
  define('HOST','localhost');
  define('USER','root');
  define('PASS','totopipo007');
  define('DB','projet');

$con = mysqli_connect(HOST,USER,PASS,DB);



$username = $_POST['UserName'];
$password = $_POST['Mdp'];
$password= hash("sha256", $password);
$userId=NULL;
$response["error"] ="erreur";

$sql = "select * from user where UserName = '".$username."' AND Mdp = '".$password. "'";

	$query = mysqli_query($con,$sql);
		$row = mysqli_fetch_assoc($query);
		$userId = $row['id'];
		$userNameBdd = $row['UserName'];
		$passwordBdd= $row['Mdp'];
		$emailBdd= $row['email'];
		
		if($userId!=NULL){
			$response["error"] ="FALSE";
			$response["id"] = $userId;
			$response["UserName"]= $userNameBdd;
			$response["Mdp"] = $passwordBdd;
			$response["email"]= $emailBdd;
			
			$sql = "update user set DateLastConnect = NOW() where UserName = '".$userNameBdd."'";
			$query = mysqli_query($con, $sql);
        
			echo json_encode($response);
		}
		
?>
