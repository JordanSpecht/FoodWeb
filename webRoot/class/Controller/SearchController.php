<?php

	if( !class_exists('Search') ) {
		include(dirname(__FILE__) . '/../Model/Search.php');
		$Search = new Search;
	}
	
	class SearchController extends Search {

		public function getNearbyZipCodes($inputZip, $radiusInMiles) {
			$response = fopen('http://zipcodedistanceapi.redline13.com/rest/sEugTvJ4a7XmdaFilRVLH5urbqwbWtcp8HG1cp6nx4KLfp4AhZmZ5RrhhXserFDA/radius.json/' . $inputZip . '/' . $radiusInMiles . '/mile', 'r');
			$response = stream_get_contents($response);
			$response = json_decode($response);
			$detailedarray = $response->{'zip_codes'};
			$zips = array();
			for($i = 0; $i < count($detailedarray); $i++) 
			{
				$zips[] =  $detailedarray[$i]->{'zip_code'};
			}
			
			return $zips;
		}
		
		public function getNearbyBusinesses($inputZip, $radiusInMiles) {
			$PDODB = $this->getPDO();
			
			$nearbyZips = $this->getNearbyZipCodes($inputZip, $radiusInMiles);
			
			$zipParams = "''";
			for($i = 0; $i < count($nearbyZips); $i++) {
				$zipParams .= ", :zip" . $i;
			}
			
			
			$q = $PDODB->prepare("SELECT V.name
										 , V.id AS vendor_id
										 , VL.address
								  FROM vendor_locations VL
								  INNER JOIN vendors V
									ON VL.vendor_id = V.id
									AND VL.zipcode IN(" . $zipParams . ");");
			for($i = 0; $i < count($nearbyZips); $i++) {
				$q->bindParam(':zip' . $i, $nearbyZips[$i]);
			}
			
			if( !$q->execute() ) {
				var_dump($q->errorInfo());
				return array();
			}
			
			return $q->fetchAll();
		}
		
	}
	
?>