<?php
error_reporting(E_ALL ^ E_DEPRECATED);

?>
<?php
$config=parse_ini_file(__DIR__."/jsheetconfig.ini");
//require_once($_SERVER['DOCUMENT_ROOT'].$config['appRoot']."/query/connect.php");

$db_host = "localhost";
$db_username = "dev";
$db_pass = "4y4ytD5X2SP5vkJM";
$db_name = "dev";
 
$con = mysqli_connect("$db_host","$db_username","$db_pass") or die ("could not connect to mysql");
 mysqli_select_db($con,$db_name);

?>