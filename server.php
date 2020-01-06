

<?php
error_reporting(E_ERROR | E_PARSE);
$start_time = time();

$marketTypeArray = ["MATCH_ODDS", "OVER_UNDER_15", "OVER_UNDER_25", "OVER_UNDER_35", "OVER_UNDER_45"];

$data = @file_get_contents('../test.nicoladefontetipster.com/betfair-data.json');
$data = json_decode($data);

$scoreData = $data->score;
$marketData = $data->market;
$marketIdsAndEventIDMapByType = $data->marketIdsAndEventIDMapByType;

$eventIdList = [];
foreach ($scoreData as $key => $value) {
	$eventIds = explode(',', $value->eventIds);
	$eventIdList = array_merge($eventIdList, explode(',', $value->eventIds));
}
$map_list = [];

$defaultTimeZone = new DateTimeZone('Europe/London');
$localTimeZone = new DateTimeZone('Europe/Rome');
foreach ($eventIdList as $i => $eventId) {
	$map = [];

	foreach ($scoreData as $key => $obj) {
		if(strpos($obj->eventIds, $eventId) !== false) {					
			foreach ($obj->data as $key1 => $val) {
				if($val->eventId == $eventId) {
					$score = $val;		
				}
			}
			
		}
	}

	// if($eventId == 29066074) {
	// 	echo "SCORE DATA: <br>";
	// 	var_dump($score);
	// 	echo "<br><br>";
	// }

	foreach ($marketTypeArray as $j => $marketType) {		
		
		$eventMp = [];
		$marketIdsAndEventIDMap = $marketIdsAndEventIDMapByType->$marketType;
		if(isset($marketIdsAndEventIDMap->$eventId)) {
			// echo $eventId . ' -- ' . $marketIdsAndEventIDMap->$eventId . ' (' . $marketType . ')' . "<br>";
			$marketId = $marketIdsAndEventIDMap->$eventId;
			foreach ($marketData->$marketType as $k => $marktetGrp) {				
				if(strpos($marktetGrp->marketIds, $marketId) !== false) {					
					foreach ($marktetGrp->data->eventTypes[0]->eventNodes as $key => $eventNode) {
						if($eventNode->eventId == $eventId) {							
							if(isset($score->state) && isset($score->state->score)) {
								$scoreValue = $score->state->score->home->score . '-' . $score->state->score->away->score;												
								$map['score'] = $scoreValue;
							} else {
								$map['score'] = '0-0';
							}

							if(isset($score->state) && isset($score->state->timeElapsed)) {
								$map["timeElapsed"] = $score->state->timeElapsed;
								if($score->state->status == 'FirstHalfEnd') {
									$map["timeElapsed"] = 'HT';
								}
							} else {
								$map["timeElapsed"] = '0';
							}

							date_default_timezone_set('Europe/Rome');
							// $startDate = date('Y-m-d H:i', strtotime($eventNode->event->openDate));
							$startDate = new DateTime($eventNode->event->openDate, $defaultTimeZone);
							$startDate->setTimezone($localTimeZone);
							$map['startTime'] = $startDate->format('Y-m-d H:i');

							//
							$currentTime = time();
							
							// from 4:00 am start....
							
							$fromTime =  mktime(4, 0, 0, date("m"), date("d"), date("y"));
							
							if($currentTime <= $fromTime) {
								$toTime = $fromTime;
								$fromTime = strtotime("-1 day", $toTime);
							} else {
								$toTime = strtotime("+1 day", $fromTime);	
							}
							
							$actualTime = strtotime($map['startTime']);
							if($actualTime < $fromTime || $actualTime > $toTime) {
								continue 4;
							}

							$map['startTime'] = $startDate->format('d/m/Y H:i');							
							$marketNode = $eventNode->marketNodes[0];
							$map['matchName'] = str_replace(' - ', ' v ', $eventNode->event->eventName);

							$map['status'] = $marketNode->state->inplay;
							$map['matchstatus'] = $marketNode->state->status;

							$eventMp['matchedMoney'] = "&pound;" . number_format(($marketNode->state->totalMatched), 0);
							$eventMp['marketId'] = $marketNode->marketId;

							$runnersNode = $marketNode->runners;
							foreach ($runnersNode as $m => $runner) {
								$key = '';
								if($marketType == 'MATCH_ODDS') {
									if ($m == 0) {
										$key = "1";
									} elseif ($m == 1) {
										$key = "2";
									} elseif ($m == 2) {
										$key = "x";
									}
								} else {
									if ($m == 0) {
										$key = "meno";
									} elseif ($m == 1) {
										$key = "piu";
									}
								}

								$exchangeNode = null;
								$mapForPriceSize = [];
								if(isset($runner->exchange)) {
									$exchangeNode = $runner->exchange;
									if (isset($exchangeNode->availableToBack)) {

										$mapForPriceSize['backPrice'] = $exchangeNode->availableToBack[0]->price;
										$mapForPriceSize['backSize'] = "&pound;" . $exchangeNode->availableToBack[0]->size;
										
									} else {
										$mapForPriceSize['backPrice'] = '';
										$mapForPriceSize['backSize'] = '';
									}
									if (isset($exchangeNode->availableToLay)) {

										$mapForPriceSize['layPrice'] = $exchangeNode->availableToLay[0]->price;
										$mapForPriceSize['laySize'] = "&pound;" . $exchangeNode->availableToLay[0]->size;

									} else {

										$mapForPriceSize['layPrice'] = '';
										$mapForPriceSize['laySize'] = '';
									}
									$eventMp[$key] = $mapForPriceSize;
								}
								

							}
							continue 2;
						}
					}
				}

			}
		} else {
		}
		$map[$marketType] = $eventMp;
		
	}

	if(check_validity($map)) {
		$map_list[] = $map;		
	}		
	
}

// print "<br><br><br><br><br>";
// var_dump($map_list);

function check_validity($map) {
	return isset($map['matchName']) && isset($map['startTime']);
}



echo json_encode(['data' => $map_list]);

// echo "Execution Time: ".(time() - $start_time)."S";