<?php

if(isset($_POST['KEY']) && isset($_POST['PM2_5']) && isset($_POST['PM10']) && isset($_POST['PM2_5_CORR']) && isset($_POST['PM10_CORR']) && isset($_POST['TEMP']) && isset($_POST['PRES']) && isset($_POST['HUMI']) && isset($_POST['LATI']) && isset($_POST['LONGI'])){

	$KEY = "01123581321345589144233";
	if($_POST['KEY'] == $KEY)
	{
		$pm2_5   = $_POST['PM2_5'];
		$pm10    = $_POST['PM10'];
		$pm2_5C  = $_POST['PM2_5_CORR'];
		$pm10C   = $_POST['PM10_CORR'];
		$temp    = $_POST['TEMP'];
		$pres    = $_POST['PRES'];
		$humi    = $_POST['HUMI'];
		$id_session = -1;
		$lati    = $_POST['LATI'];
		$longi   = $_POST['LONGI'];
		$session = $_POST['SESSION']; 
		
		$configuration = require_once 'config.php';
		try {	
			$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
				PDO::ATTR_EMULATE_PREPARES => false, 
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]); 


			$stmt_p = $db->query("SELECT ID_SESSION FROM PM ORDER BY ID DESC LIMIT 1");
			$stmt_p->execute();
			$f = $stmt_p->fetch();
			$result = intval($f['ID_SESSION']);
			$stmt_p->closeCursor();
			 
		 
		   if($session){
		 	    $stmt= $db->prepare("INSERT INTO PM (PM2_5, PM10, PM2_5_CORR, PM_10_CORR, HUMIDITY, TEMPERATURE, PRESSURE, ID_SESSION, LATITUDE_ORG, LONGITUDE_ORG, DATE_SAVE) VALUES (?,?,?,?,?,?,?,?,?,?,NOW())");
				$stmt->bindParam(1, $pm2_5);
				$stmt->bindParam(2, $pm10);
				$stmt->bindParam(3, $pm2_5C);
				$stmt->bindParam(4, $pm10C);
				$stmt->bindParam(5, $humi);
				$stmt->bindParam(6, $temp);
				$stmt->bindParam(7, $pres);
				$stmt->bindParam(8, $result);		
				$stmt->bindParam(9, $lati);
				$stmt->bindParam(10, $longi); 
		 	}else{
		 		$result = $result+1;
		 		$stmt= $db->prepare("INSERT INTO PM (PM2_5, PM10, PM2_5_CORR, PM_10_CORR, HUMIDITY, TEMPERATURE, PRESSURE, ID_SESSION, LATITUDE_ORG, LONGITUDE_ORG, DATE_SAVE) VALUES (?,?,?,?,?,?,?,?,?,?,NOW())");
				$stmt->bindParam(1, $pm2_5);
				$stmt->bindParam(2, $pm10);
				$stmt->bindParam(3, $pm2_5C);
				$stmt->bindParam(4, $pm10C);
				$stmt->bindParam(5, $humi);
				$stmt->bindParam(6, $temp);
				$stmt->bindParam(7, $pres);
				$stmt->bindParam(8, $result);		
				$stmt->bindParam(9, $lati);
				$stmt->bindParam(10, $longi); 

		 	} 

		 	if($stmt->execute()){
		 		//require_once 'settingLocations.php'; 
				echo json_encode(true);
		 	}else{
				echo json_encode(false);

		 	}		
		 	$stmt->closeCursor();	

			
		} catch (PDOException $error) {
			
			echo $error->getMessage();
			echo json_encode("false");	
		}
	}else{
		echo json_encode($_POST['KEY']);
	}
}else{
	echo json_encode("false1");
}