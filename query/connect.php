<?php

	function connectDb(){
    $addr="localhost";
		$db="dev";
		$user="dev";
		$password='4y4ytD5X2SP5vkJM';
		$con = mysqli_connect($addr,$user,$password,$db);

		if (mysqli_connect_errno())
		{
			die("Failed to connect to MySQL: " . mysqli_connect_error());
		}
		return $con;
	}

	function pdoConnect(){
		$addr="localhost";
		$db="dev";
		$user="dev";
		$password='4y4ytD5X2SP5vkJM';
		//$pdo = "'mysql:host=".$addr.";dbname=".$db."', '".$user."', '".$password."'";
		$con = array();
		$con[0] = "mysql:host=".$addr.";dbname=".$db;
		$con[1] = $user;
		$con[2] = $password;
		return $con;
	}
?>