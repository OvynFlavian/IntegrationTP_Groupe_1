<?php
	define('HOST','localhost');
	define('USER','root');
	define('PASS','poulet77');
	define('DB','projetIntegration');
	
	/**
	  * Fonction comparant la date du jour et une date donnée avec un délai en heure.
      * @param $date : la date que l'on souhaite comparer.
      * @param $delai : le délai en heure souhaité.
      * @return bool : true si la date du jour est plus grande que la date+délai, false si elle est plus petite.
      */
    function comparerHeure($date, $delai) {
        if ($delai == 0) {
            return false;
        } else {
            $datejour = date('Y-m-d H:i:s');
            $datejour = strtotime($datejour);
            $date = strtotime(date("Y-m-d H:i:s",strtotime($date))."+$delai hour");
            if ($datejour > $date) {
                return true;
            } else {
                return false;
            }
        }
    }

	$con = mysqli_connect(HOST,USER,PASS,DB);
	
	$userId = $_POST['userId'];
	
	$sql = "select date from user_activity where id_User = '".$userId."'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($res);
	$date = $row['date'];
	
	$retour['check'] = comparerHeure($date, 2);
	
	echo json_encode($retour);
	
	
?>