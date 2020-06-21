<?php		

$configuration = require_once 'config.php'; 

try {
	$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
		PDO::ATTR_EMULATE_PREPARES => false, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);  

	$latitude  = [];
	$longitude = []; 
	$locations = array();
	$lat  = [];
	$long = [];
	$numb = []; 
	$date = []; 

	$stmt = $db->prepare("SELECT LATITUDE_CEN, LONGITUDE_CEN FROM PM");
	$stmt->execute();
	$rows = $stmt->rowCount();	
	$i = 0;
	foreach($stmt as $row){
		$latitude[$i]  = $row['LATITUDE_CEN'];
		$longitude[$i] = $row['LONGITUDE_CEN'];
		$i++;				
	}


	$locations[0]['LATI'] = $latitude[0];
	$locations[0]['LONG'] = $longitude[0];

	
	$k = 0;
	$st = false;
	for($j=1; $j<$rows; $j++){
		for($l=0; $l<count($locations); $l++){
			if($locations[$l]['LATI'] == $latitude[$j] && $locations[$l]['LONG'] == $longitude[$j]){
				$st = false;
			 	break;
			}else{
				$st = true;
			}
		}

		if($st){
			$st = false;
			$k++;
			$locations[$k]['LATI'] = $latitude[$j];
			$locations[$k]['LONG'] = $longitude[$j];
		}
	}
	

	for($p=0; $p<count($locations);$p++){
		$stmt = $db->prepare("SELECT * FROM PM WHERE LATITUDE_CEN=:lat AND LONGITUDE_CEN=:long");
		$stmt->execute(
		array(
		        'lat' => $locations[$p]['LATI'],
		        'long' => $locations[$p]['LONG']
		    )
		);
		$locations[$p]['NUMB'] = $stmt->rowCount();	 
	}

	for($p=0; $p<count($locations);$p++){
		$stmt = $db->query("SELECT * FROM PM WHERE LATITUDE_CEN=:lat AND LONGITUDE_CEN=:long ORDER BY DATE_SAVE DESC LIMIT 1 ");
		$stmt->execute(
		array(
		        'lat' => $locations[$p]['LATI'],
		        'long' => $locations[$p]['LONG']
		    )
		);
		foreach($stmt as $row){
			$locations[$p]['DATE']  = $row['DATE_SAVE'];								
		} 
	}

	echo json_encode($locations)."</br>"; 

} catch (PDOException $error) {
	
	echo $error->getMessage();
	exit('Database error');	
}