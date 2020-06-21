<?php

if(isset($_GET['KEY']) && isset($_GET['TIME_MEASURE']) && isset($_GET['NUMBERS_MEASURE']) && isset($_GET['BREAK_TIME']) && isset($_GET['RADIUS'])){

	$KEY = "01123581321345589144233";
	if($_GET['KEY'] == $KEY)
	{
		$time_measure     = $_GET['TIME_MEASURE'];
		$numbers_measure  = $_GET['NUMBERS_MEASURE'];
		$break_time       = $_GET['BREAK_TIME'];
		$radius           = $_GET['RADIUS'];
		
		$configuration = require_once 'config.php';
		$data = [
			'time_measure'    => $time_measure,
			'numbers_measure' => $numbers_measure,
			'break_time'      => $break_time,
			'radius'      	  => $radius,
			'id'              => 1,
		];
		try {	
			$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
				PDO::ATTR_EMULATE_PREPARES => false, 
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]); 
			$sql = "UPDATE CONFIG SET TIME_MEASURE=:time_measure, N_MEASURES=:numbers_measure, BREAK_TIME=:break_time, RADIUS=:radius WHERE ID=:id";
			$stmt= $db->prepare($sql)->execute($data); 
			echo json_encode(true);
			
		} catch (PDOException $error) {
			
			echo $error->getMessage();
			echo json_encode(false);	
		}
	}
}else{
	echo json_encode(false);
}