<?php
  define('HOST','localhost');
  define('USER','root');
  define('PASS','LUCIENNE1223');
  define('DB','projetintegration');

$con = mysqli_connect(HOST,USER,PASS,DB);



$username = $_POST['username'];
$password = $_POST['password'];

$sql = "select * from user where userName = '".$username."' AND password = '".$password. "'";

$res = mysqli_query($con,$sql);

$rows = mysqli_num_rows($res);
//echo $rows;
 if($rows == 0) { 
 echo "No Such User Found"; 
 }
 else  {
	echo "User Found"; 
}
?>
