 <?php
  define('HOST','localhost');
  define('USER','root');
  define('PASS','LUCIENNE1223');
  define('DB','projetintegration');

$con = mysqli_connect(HOST,USER,PASS,DB);

$sql = "select * from user";

$res = mysqli_query($con,$sql);

$result = array();

while($row = mysqli_fetch_array($res)){
array_push($result,
array('id'=>$row[0],
'username'=>$row[1],
'mdp'=>$row[2]
));
}

echo json_encode(array("result"=>$result));

mysqli_close($con);
?>