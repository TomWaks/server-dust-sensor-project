<?php
if(isset($_POST['KEY']) && isset($_POST['IS_SET_LOCATION']) && isset($_POST['L_LAT']) && isset($_POST['L_LONG']) && isset($_POST['ACC']))
{
	$KEY = "01123581321345589144233";

	if($_POST['KEY'] == $KEY)
	{

		$is_set_location 	= $_POST['IS_SET_LOCATION'];
		$l_lat  			= $_POST['L_LAT'];
	    $l_long 			= $_POST['L_LONG'];
		$acc    			= $_POST['ACC'];

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
			$config->time = time()+7200;

			$stmt->connection = null;

			/********CHANGE STATUS*********************************/

			$stmt = $db->prepare("UPDATE CONFIG SET STATUS = 1, LAST_ACTIVE = NOW()");
			$stmt->execute();

			$stmt->connection = null;

			/*******SET LOCATION***********************************/

			if(!$is_set_location){
				$stmt = $db->prepare("UPDATE CONFIG SET STATUS=1, LAST_LATITUDE = :l_lat, LAST_LONGITUDE = :l_long, ACCURACY = :acc WHERE ID=1");
				$stmt->execute(
				    array(
				        'l_lat' => $l_lat,
				        'l_long' => $l_long,
				        'acc' => $acc
				    )
				);				
				$count = $stmt->rowCount();

				if($count == '0'){
					$config->status = false;
				}
				else{
					$config->status = true;
				} 
				$stmt->connection = null;
			}else{
				$config->status = false;				
			}

			$con = json_encode($config); 
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

