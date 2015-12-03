<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');
				
				
		$con = mysqli_connect(HOST,USER,PASS,DB);
         $email = $_POST['email'];
			$sql = "select * from user where email = '".$email."' ";
		 	$res = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($res);
			$id = $row['id'];
		 $msg= "echec.";
		 
          $inconnu = false;
          if ($res == false) {
              $inconnu = true;
          }

          if ($inconnu) {
              $msg= "Cet email n'est pas répertorié.";
          } 
		  else {
              $code_aleatoire = genererCode();
              
              $to = $email;
              $sujet = "Confirmation de la demande du mot de passe";
              $entete="From:postmaster@everydayidea.be\r\n";
              $entete .= "Content-Type: text/html; charset=utf-8\r\n";
              $message = "Nous confirmons que vous avez bien demandé un nouveau mot de passe : <br>
							Votre lien pour pouvoir le modifier est : <a href='http://www.everydayidea.be/Page/mdpOublie.page.php?code=" . $code_aleatoire . "'>Cliquez ici</a>";
              mail($to, $sujet, $message, $entete);
              $msg=" Un mail vous a été envoyé" ;

			  
			  	$sql = "insert into activation (code, id_user, libelle) values ('".$code_aleatoire."', '".$id."', 'Récupération')";
				$res = mysqli_query($con, $sql);
		  }  
			echo $msg;
			  
			  
		function genererCode() {
			$characts    = 'abcdefghijklmnopqrstuvwxyz';
			$characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$characts   .= '1234567890';
			$code_aleatoire      = '';

			for($i=0;$i < 6;$i++){
				$code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
			}
			return $code_aleatoire;
		}
			  
?>