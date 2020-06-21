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

			$stmt = $db->prepare(("UPDATE STATUS SET STATUS=1 WHERE ID=1"));
			$stmt->execute(); 
			$stmt->connection = null;
			echo json_encode(true);
			
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

