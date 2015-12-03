<?php
	
	if(isset($_POST['imageName'])){
		$repertoire = "../Images/activite/";
		$imageName = $_POST['imageName'];
		$image = base64_decode($_POST['base64']);
		
		$fp = fopen($repertoire.$imageName, 'w');
		fwrite($fp, $image);
		
		$donnees = getimagesize($repertoire.$imageName);
		$nouvelleLargeur = 250;
		$reduction = ( ($nouvelleLargeur * 100) / $donnees[0]);
		$nouvelleHauteur = ( ($donnees[1] * $reduction) / 100);
		$image2 = imagecreatefromjpeg($repertoire.$imageName);
		$image_mini = imagecreatetruecolor($nouvelleLargeur, $nouvelleHauteur);
		imagecopyresampled($image_mini, $image2, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $donnees[0], $donnees[1]);
		imagejpeg ($image_mini, $repertoire.$imageName);
		
		if(fclose($fp)){
			echo "Image uploaded";
		}else{
			echo "Error uploading image";
		}
	} else {
		echo "echec";
	}
	
?>