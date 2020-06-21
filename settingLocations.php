<?php





			$configuration = require_once 'config.php';
		try {
			$db = new PDO("mysql:host={$configuration['host']};dbname={$configuration['database']};charset=utf8", $configuration['user'], $configuration['password'], [
				PDO::ATTR_EMULATE_PREPARES => false, 
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);  

			$id = [];
			$latitude  = [];
			$longitude = []; 
			$status = [];
			$id_session = -1;

			$fin = [];  
			$radius = 0;

			$stmt = $db->query("SELECT RADIUS FROM CONFIG");
			$stmt->execute();
			foreach($stmt as $row){
				$radius  = $row['RADIUS'];

			}

			$stmt = $db->query("SELECT * FROM PM ORDER BY ID DESC LIMIT 1");
			$stmt->execute();
			$rows = $stmt->rowCount();	


			$k = 0;
			foreach($stmt as $row){
				$id_session  = $row['ID_SESSION'];

			}

			for($h=1; $h<=$id_session; $h++){
				$stmt = $db->prepare("SELECT * FROM PM WHERE ID_SESSION = '$h' LIMIT 1");
				$stmt->execute();

				foreach($stmt as $row){
					$id[$h]        = $row['ID'];
					$latitude[$h]  = $row['LATITUDE_ORG'];
					$longitude[$h] = $row['LONGITUDE_ORG'];
				}
			}

			for($h=1; $h<=$id_session; $h++){
				$fin[$h] = $h; 				
			}

			for($h=1; $h<=$id_session; $h++){
				for($j=1; $j<=$id_session; $j++){
					if($h<$j && $status[$j] == 0 && $status [$h] == 0){
						if(distanceByHaversine($latitude[$h], $longitude[$h], $latitude[$j], $longitude[$j])<$radius){
							$status[$j] = 1;
							$fin[$j] = $h;

						}
					}					
				}				
			}
			for($h=1; $h<=$id_session; $h++){

				$stmt = $db->prepare(("UPDATE PM SET LATITUDE_CEN = :lat, LONGITUDE_CEN = :long WHERE ID_SESSION = '$h'"));
				$stmt->execute(
					array(
					        'lat' => $latitude[$fin[$h]],
					        'long' => $longitude[$fin[$h]]
					    )
					);
			}

			for($h=1; $h<=$id_session; $h++){
				echo $h." -> ".$fin[$h]."</br>";
			}		

		} catch (PDOException $error) {
			
			echo $error->getMessage();
			exit('Database error');	
		}




function distanceByHaversine(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  return round($angle * $earthRadius,2);
}



