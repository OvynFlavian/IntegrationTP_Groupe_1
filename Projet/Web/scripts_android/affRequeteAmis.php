<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];
	$i=0;
	$response[$i]["error"]="TRUE";

	$sql = "select * from amis where (id_user_1 = '".$id."') and accepte='0' ";

	$query = mysqli_query($con,$sql);
	
	
	//rajouter le fait de ne pas pouvoir s'ajouter soi meme.
	//regarder dans le id_user_1 et le id_user_2 pour la recherche.
	//afficher que si amis accepté.
	

	while($row = mysqli_fetch_assoc($query)){
		
		if ($row['id_user_2']== $id){
			$userId = $row['id_user_1'];
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
		/*if ($row['id_user_1']== $id){
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
			
			
		}*/
		
		
	}	
        
	echo json_encode($response);
	
	// ne renvoie rien, surement une erreur dans la requete, verifier les "nom" des champs.

		
?>
