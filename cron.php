<?php

	
	$configuration = [
		'host' => 'localhost', 
		'user' => '************',
		'password' => '*********',
		'database' => '**********'
	];
	
	try {

		$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
			PDO::ATTR_EMULATE_PREPARES => false, 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);

		$stmt = $db->query("SELECT * FROM CONFIG");
		$data = $stmt->fetch();

		$date = $data['LAST_ACTIVE']; 
		$stmt->connection = null; 

		$stmt = $db->prepare(("UPDATE CONFIG SET STATUS = 0 WHERE (NOW() - INTERVAL 30 SECOND) > :date"));
		$stmt->execute(
			array(
			        'date' => $date
			    )
			);

		if($stmt->rowCount() == '0'){
			echo json_encode();
		}
		else{
			echo json_encode(true);
		}
		
	} catch (PDOException $error) {
		
		echo $error->getMessage();
		exit('Database error');	
	}
