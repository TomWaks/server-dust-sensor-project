<?php
if(isset($_GET['KEY']) && isset($_GET['DAY']) && isset($_GET['L_LATI']) && isset($_GET['L_LONG']))
{
	$KEY = "01123581321345589144233";
	if($_GET['KEY'] == $KEY)
	{
		$configuration = require_once 'config.php';
		try {
	
			$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
				PDO::ATTR_EMULATE_PREPARES => false, 
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);  			
			$date      = $_GET['DAY'];
			$date_from = $date." 00:00:00";
			$date_to   = $date." 23:59:59";
			$l_lat     = $_GET['L_LATI'];
			$l_long	   = $_GET['L_LONG'];

			$stmt = $db->query("SELECT * FROM PM WHERE PM.DATE_SAVE>='$date_from' AND PM.DATE_SAVE<='$date_to' AND LATITUDE_CEN='$l_lat' AND LONGITUDE_CEN='$l_long'");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$con = json_encode($data);  
			
			echo $con;
			
		} catch (PDOException $error) {
			
			echo $error->getMessage();
			exit('Database error');	
		}
	} else{
		echo json_encode(false);
	}
} else{
	echo json_encode(false);
}