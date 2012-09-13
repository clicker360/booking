<?php

//Return true if the page should be available as per config, else false
function isavailable() {
	require_once('db.php');
	
	$conn = mysql_connect($dbhost, $dbuser, $dbpasswd) or die(mysql_error());
	mysql_select_db($db, $conn) or die(mysql_error());
	$available_sql = "SELECT 1 as available FROM booking_config WHERE setting = 'available' AND DATE_FORMAT(NOW(),'%Y%m%d%H%i%s') BETWEEN SUBSTRING(value,1,14) AND SUBSTRING(value,16,14);";
	$available_result = mysql_query($available_sql);
	$available = 0;
	while($available_row = mysql_fetch_array($available_result)) {
		$available = $available_row['available'];
	}
	if($available == 1) {
		return true;
	} else {
		return false;
	}
}

function tstosec($timestamp) {
	$return = 0;
	$h = 0;
	$i = 0;
	$s = 0;
	if(strlen($timestamp) == 14) {
		$y = substr($timestamp, 0, 4);
		$m = substr($timestamp, 4, 2);
		$d = substr($timestamp, 6, 2);
		$h = substr($timestamp, 8, 1) == 0? substr($timestamp, 9, 1) : substr($timestamp, 8, 2);
		$i = substr($timestamp, 10, 1) == 0? substr($timestamp, 11, 1) : substr($timestamp, 10, 2);
		$s = substr($timestamp, 12, 1) == 0? substr($timestamp, 13, 1) : substr($timestamp, 12, 2);
	} elseif(strlen($timestamp) == 6) {
		$h = substr($timestamp, 0, 1) == 0? substr($timestamp, 1, 1) : substr($timestamp, 0, 2);
		$i = substr($timestamp, 2, 1) == 0? substr($timestamp, 3, 1) : substr($timestamp, 2, 2);
		$s = substr($timestamp, 4, 1) == 0? substr($timestamp, 5, 1) : substr($timestamp, 4, 2);
	}
	$h = (int) $h;
	$i = (int) $i;
	$s = (int) $s;
	$hs = $h*3600;
	$is = $i*60;
	$return = $hs+$is+$s;
	return $return;
}

function sectots($sec){
	$h = intval($sec / 3600);
	$sec = $sec % 3600;
	$m = intval($sec / 60);
	$sec = $sec % 60;
	if($h < 10) {
		$h = 0 . $h;
	}
	if($m < 10) {
		$m = 0 . $m;
	}
	if($sec < 10) {
		$sec = 0 . $sec;
	}
	return $h . $m . $sec;
}
/*
if(isavailable()){
	echo "1";	
} else {
	echo "0";
}
*/

$ts1 = tstosec('20120911182400');
$ts2 = tstosec('182400');
$ts3 = sectots($ts2);
echo "-> " . $ts1 . " -> " . $ts2 . " -> " . $ts3;
?>