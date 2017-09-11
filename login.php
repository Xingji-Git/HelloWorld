<?php

function login($username, $passwd){
	try{
		$conn = new PDO("mysql:host=localhost;dbname=myDB","root","s90wsnXz");
	}
	catch(PDOException $e){
		echo "Failed: ".$e->getMessage();
	}
	$stmt = "select * from users where user = \"$username\" and passwd = \"$passwd\"";
	$result = $conn->query($stmt);
	return $result;
}

?>
