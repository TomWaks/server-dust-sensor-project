<?php


$configuration = require_once 'config.php';
try {

		$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
			PDO::ATTR_EMULATE_PREPARES => false, 
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);  		

		/**********GET DATA CONFIG********************************/	

		$stmt = $db->query("SELECT * FROM CONFIG");
		$data = $stmt->fetch();

		$config->timeMeasure = $data['TIME_MEASURE'];
		$config->nMeasures   = $data['N_MEASURES'];
		$config->breakTime   = $data['BREAK_TIME'];
		$config->radius      = $data['RADIUS'];
		$stmt->connection = null;

		echo json_encode($config);
		
	} catch (PDOException $error) {
		
		echo $error->getMessage();
		exit('Database error');	
	}