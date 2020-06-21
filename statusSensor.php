<?php
if(isset($_GET['KEY']))
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

			$dates = [];
			$datesOne = []; 

			$stmt = $db->query("SELECT STATUS, LAST_ACTIVE, LAST_LATITUDE, LAST_LONGITUDE FROM CONFIG");
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