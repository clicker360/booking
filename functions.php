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

if(isavailable()){
	echo "1";	
} else {
	echo "0";
}

?>