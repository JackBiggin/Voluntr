<?php
	session_start();

	

	//$test = urlencode("Raleigh-Durham, North Carolina Area");

	$user_location = urlencode($_SESSION['location']);

	$api2 = file_get_contents("https://geocoder.api.here.com/6.2/geocode.json?searchtext=" . $user_location . "&app_id=e0sebt0gq7D5QJQsDtSv&app_code=1fqtmWy8S7eV9qPtA3sGzw");

	$api2 = json_decode($api2, true);

	$lat = $api2["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Latitude"];

	$long = $api2["Response"]["View"][0]["Result"][0]["Location"]["DisplayPosition"]["Longitude"];

	//print_r($api2);
	//echo $api["response"]["route"][0]["summary"]["distance"];
	
	$waypoint0 = "geo!" . $lat . "," . $long;

	$api = file_get_contents("https://route.api.here.com/routing/7.2/calculateroute.json?waypoint0=" . urlencode($waypoint0) . "&waypoint1=52.5206%2C13.3862&mode=fastest%3Bcar%3Btraffic%3Aenabled&app_id=devportal-demo-20180625&app_code=9v2BkviRwi9Ot26kp2IysQ&departure=now");

	$api = json_decode($api, true);

	echo $waypoint0;
?>