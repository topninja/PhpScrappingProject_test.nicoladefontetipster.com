<?php
@file_put_contents('log.txt',  date("Y-m-d h:i:sa") . '\n');

$marketTypeArray = ["MATCH_ODDS", "OVER_UNDER_15", "OVER_UNDER_25", "OVER_UNDER_35", "OVER_UNDER_45"];
// $marketTypeArray = ["MATCH_ODDS"];

function getMarketIds() {
	global $marketTypeArray;

	$marketTypeMap = [];
	foreach ($marketTypeArray as $marketType) {
		$marketTypeMap[$marketType] = getMarketIdsByType($marketType);
	}

	return $marketTypeMap;
}


function getMarketIdsByType($marketType) {
	$curl = curl_init();

	$jsonRequestBody = ['filter' => ['marketBettingTypes' => ['ODDS'],'productTypes' => ['EXCHANGE'],'marketTypeCodes' => [],'selectBy' =>'FIRST_TO_START_AZ','contentGroup' => ['language' => 'en','regionCode' => 'UK'],'turnInPlayEnabled' => true,'maxResults' => 1000,'eventTypeIds' => [1]],'currencyCode' => 'GBP','locale' => 'it'];

	$jsonRequestBody['filter']['marketTypeCodes'][] = $marketType;


	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://www.betfair.com/www/sports/navigation/facet/v1/search?_ak=nzIFcwyWhrlwYMrh&alt=json",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_POSTFIELDS => json_encode($jsonRequestBody),
	  // CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
	  	"origin: https://www.betfair.com",
	  	// "accept-encoding: gzip, deflate, br",
	  	// "accept-language: en-GB,en-US;q=0.9,en;q=0.8",    
		// "user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36",
		"content-type: application/json",
		// "accept: application/json",
		"referer: https://www.betfair.com/exchange/plus/football",
		// "connection", "keep-alive",
		// "cache-control", "no-cache"    
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);

	$map = array();

	if ($err) {

	  echo "cURL Error #:" . $err;

	} else {
	  // echo $response;
		
		foreach (json_decode($response)->results as $key => $val) {
			
			$map[$val->eventId] = $val->marketId;
			//echo $val->eventId.', '.$val->marketId.', '.$val->competitionId.', '.$val->eventTypeId.'<br>';

		}
	}
	return $map;
}

function multiRequest($IdsStringArr) {	

	$curly = array();	

	$mh = curl_multi_init();

	// foreach ($data as $id => $d) {
	foreach ($IdsStringArr as $id => $IdsString) {
 
	    $curly[$id] = curl_init();
		
		if($IdsString['idType'] == 'market') {
			$url = "https://www.betfair.com/www/sports/exchange/readonly/v1/bymarket?_ak=nzIFcwyWhrlwYMrh&alt=json&currencyCode=GBP&locale=it&marketIds=". $IdsString['marketIdString']."&rollupLimit=10&rollupModel=STAKE&types=MARKET_STATE,EVENT,RUNNER_EXCHANGE_PRICES_BEST";
		} else {
			$url = "https://ips.betfair.com/inplayservice/v1/scoresAndBroadcast?_ak=nzIFcwyWhrlwYMrh&alt=json&eventIds=".$IdsString['eventIdString']."&locale=it&regionCode=UK";
		}

		curl_setopt_array($curly[$id], array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"origin: https://www.betfair.com",
				"accept-encoding: gzip, deflate, br",
				"accept-language: en-GB,en-US;q=0.9,en;q=0.8",    
			"user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36",
			"content-type: application/json",
			"accept: application/json",
			"referer: https://www.betfair.com/exchange/plus/football",
			"connection", "keep-alive",
			"cache-control", "no-cache"    
			),
		));
	 
		curl_multi_add_handle($mh, $curly[$id]);
	}
 
	$running = null;
	do {
		curl_multi_exec($mh, $running);
	} while($running > 0);

	$retData = [];	

	foreach($curly as $id => $c) {
		$data = curl_multi_getcontent($c);
		$_data = json_decode($data);
		if($IdsStringArr[$id]['idType'] == 'market') {
			$retData['market'][$IdsStringArr[$id]['marketType']][] = [								
				'marketIds' => $IdsStringArr[$id]['marketIdString'],
				'data' => $_data
			];
		} else {
			$retData['score'][] = [				
				'eventIds' => $IdsStringArr[$id]['eventIdString'],
				'data' => $_data
			];
		}
		
		curl_multi_remove_handle($mh, $c);
	}
 
	curl_multi_close($mh);

	return $retData;
}



function getScore($eventIdString){
	$curl = curl_init();

	$url = "https://ips.betfair.com/inplayservice/v1/scoresAndBroadcast?_ak=nzIFcwyWhrlwYMrh&alt=json&eventIds=".$eventIdString."&locale=it&regionCode=UK";

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	  	"origin: https://www.betfair.com",
	  	"accept-encoding: gzip, deflate, br",
	  	"accept-language: en-GB,en-US;q=0.9,en;q=0.8",    
		"user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.67 Safari/537.36",
		"content-type: application/json",
		"accept: application/json",
		"referer: https://www.betfair.com/exchange/plus/football",
		"connection", "keep-alive",
		"cache-control", "no-cache"    
	  ),
	));
	
	$response = curl_exec($curl);
	echo $response . " <br>";
	die();

	$err = curl_error($curl);
	
	curl_close($curl);	

	return json_decode($response);
}

function get_data_from_betfair() {
	$start_time = time();

	$cluster_size = 40;
	$marketIdsAndEventIDMapByType = getMarketIds();

	// var_dump($marketIdsAndEventIDMapByType);
	// die();
	$finalData = [];
	$IdsStringArr = [];


	foreach ($marketIdsAndEventIDMapByType as $marketType => $marketIdsAndEventIDMap) {	

		$total_count = count($marketIdsAndEventIDMap);
		$page_count = $total_count / $cluster_size;
		$i = 0;
		$marketIDsSeg = [];
		$eventIDsSeg = [];

		foreach ($marketIdsAndEventIDMap as $eventId => $marketId) {
			$i++;
			$marketIDsSeg[] = $marketId;
			$eventIDsSeg[] = $eventId;
			if(($i != 0 && ($i % $cluster_size) == 0) || $i == $total_count-1) {

				$marketIdString = implode(',', $marketIDsSeg);			

				$IdsStringArr[] = ['idType' => 'market',  'marketType' => $marketType, 'marketIdString' =>  $marketIdString];

				if($marketType == "MATCH_ODDS") {
					$eventIdString = implode(',', $eventIDsSeg);
					$IdsStringArr[] = ['idType' => 'event',  'eventIdString' =>  $eventIdString];	
				}
				

				$marketIDsSeg = [];
				$eventIDsSeg = [];
			
			}
		}

	}
	// var_dump($IdsStringArr);
	$finalData = multiRequest($IdsStringArr);

	$finalData['marketIdsAndEventIDMapByType'] = $marketIdsAndEventIDMapByType;
	@file_put_contents('/var/www/test.nicoladefontetipster.com/betfair-data.json', json_encode($finalData));
	// var_dump($finalData);	
	echo "Execution Time: ".(time() - $start_time)."S<br/>" . PHP_EOL;
	ob_flush();	
	flush();
}


$lifetime = 60;
$initialTime = time();
for($i=0; $i < 3; $i++) {
	get_data_from_betfair();
	$elapsedTime = time() - $initialTime;
	if($elapsedTime > $lifetime) {
		echo "END";
		die();
	}
}
// get_data_from_betfair();