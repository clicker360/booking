<?php
//Read the config
$config = 'config.xml';
$configxml = simplexml_load_file($config);

print_r($configxml);
echo "<br /><br />";
//General config
$campaign = $configxml->general->name;

//Write DB config
$db = $configxml->db->attributes()->name;
$dbhost= $configxml->db->attributes()->host;
$dbuser = $configxml->db->attributes()->user;
$dbpasswd = $configxml->db->attributes()->password;

$configstr = "<?php
\$dbhost = '" . $dbhost . "';
\$dbuser = '" . $dbuser . "';
\$dbpasswd = '" . $dbpasswd . "';
\$db = '" . $db . "';
?>";

$dbfile = "db.php";
/*
$fh = fopen($dbfile, 'w') or die("can't write db file");
fwrite($fh, $configstr);
fclose($fh);
*/
echo "
Write in " . $dbfile . ":
<xmp>" . $configstr . "</xmp>
";

$createdb_sql = "CREATE DATABASE " . $db . ";";
$dropconfig_sql = "DROP TABLE IF EXISTS booking_config;";
$createconfig_sql = "
CREATE TABLE booking_config (
id int(11) NOT NULL AUTO_INCREMENT,
setting varchar(255) NOT NULL,
value varchar(255) NULL,
PRIMARY KEY(id)
);";

//Write config
/*
$conn = mysql_connect($dbhost, $dbuser, $dbpasswd) or die(mysql_error());
mysql_query($createdb_sql);
mysql_select_db($db, $conn) or die(mysql_error());
$campaign_sql = "INSERT INTO booking_config VALUES('','campaign','" . $campaign . "')";
mysql_query($dropconfig_sql);
mysql_query($createconfig_sql);
mysql_query($campaign_sql);
*/
echo "In MySQL:<br /><br />\n<xmp>" . $createdb_sql . "</xmp><xmp>" . $createconfig_sql . "</xmp>\n";
echo "<xmp>";
foreach($configxml->general->available as $available){
	$available_sql = "INSERT INTO booking_config VALUES('','available','" . $available->start . "-" . $available->end . "');";
	//mysql_query($available_sql);
	echo $available_sql . "\n";
}
echo "</xmp>";

//mysql_close();
?>