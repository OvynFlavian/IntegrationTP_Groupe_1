<?php
	
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
  define('DB','projetIntegration');

	$con = mysqli_connect(HOST,USER,PASS,DB);


	$id= $_POST['id'];
	$i=0;
	$response[$i]["error"]="TRUE";

	$sql = "select * from groupe_invitation where (id_user_demande = '".$id."') and accepte='0' ";

	$query = mysqli_query($con,$sql);
	
	
	//rajouter le fait de ne pas pouvoir s'ajouter soi meme.
	//regarder dans le id_user_1 et le id_user_2 pour la recherche.
	//afficher que si amis accepté.
	

	while($row = mysqli_fetch_assoc($query)){
		
		if ($row['id_user_demande']== $id){
			$userId = $row['id_user_envoi'];
			$idGroupe = $row['id_groupe'];
			
			$sql2 = "select * from user where id = '".$userId."' ";
			$query2 = mysqli_query($con,$sql2);
			$row2=mysqli_fetch_assoc($query2);
			$userNameBdd = $row2['UserName'];
			
			$sql3 = "select * from groupe where id_groupe = '".$idGroupe."' ";
			$query3 = mysqli_query($con,$sql3);
			$row3=mysqli_fetch_assoc($query3);
			$description = $row3['description'];
			
			
		
			if($userId!=NULL) {
				$response[$i]["error"] ="FALSE";
				$response[$i]["userName"]= $userNameBdd;
				$response[$i]["description"]= $description;
			}	
		
			$i++;
		}
		
		
		
	}	
        
	echo json_encode($response);
	
	
		
?>
