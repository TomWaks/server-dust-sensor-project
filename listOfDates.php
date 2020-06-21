<?php
if(isset($_GET['KEY']) && isset($_GET['LATI']) && isset($_GET['LONGI']))
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

			$lati    = $_GET['LATI'];
			$longi   = $_GET['LONGI'];

			$dates = [];
			$datesOne = []; 


			$listOfDates = array();

			$stmt = $db->query("SELECT DATE_SAVE FROM PM WHERE LATITUDE_CEN = :lati AND LONGITUDE_CEN = :longi");
			$stmt->execute(
				array(
				        'lati' => $lati,
				        'longi' => $longi 
				    )
				);

			$i = 0;
			$j = 0;

			foreach($stmt as $row)
			{
				  $dates[$i] = substr($row['DATE_SAVE'], 0, 10); 
			  if(!in_array($dates[$i], $datesOne)){
			  	$datesOne[$j] = $dates[$i];
			  	$j++;
			  }
			  $i++;
			}

			for($k=0;$k<count($datesOne);$k++){
				$listOfDates[$k]['DATE'] = $datesOne[$k];
			} 
			
			echo json_encode($listOfDates); 
			
		} catch (PDOException $error) {
			
			echo $error->getMessage();
			exit('Database error');	
		}
	} else{
		echo json_encode(fals);
	}
} else{
	echo json_encode(false);
}