<?php
  define('HOST','localhost');
  define('USER','root');
  define('PASS','LUCIENNE1223');
  define('DB','projetintegration');

$con = mysqli_connect(HOST,USER,PASS,DB);



$username = $_POST['username'];
$password = $_POST['password'];
$password= hash("sha256", $password);
$userId=NULL;
$response["error"] =null;

$sql = "select * from user where userName = '".$username."' AND password = '".$password. "'";

	$query = mysqli_query($con,$sql);
		$row = mysqli_fetch_assoc($query);
		$userId = $row['id'];
		$userNameBdd = $row['userName'];
		$passwordBdd= $row['password'];
		$emailBdd= $row['email'];
		$publicBdd= $row['public'];
		
		if($userId!=NULL){
			$response["error"] ="FALSE";
			$response["id"] = $userId;
			$response["userName"]= $userNameBdd;
			$response["password"] = $passwordBdd;
			$response["email"]= $emailBdd;
			$response["publics"] = $publicBdd;
        
			echo json_encode($response);
		}
		
?>
