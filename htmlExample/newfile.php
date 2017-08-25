<?php
$servername = "localhost";
$username = "root";
$password = "Zxj19931101";

try {
	$conn = new PDO("mysql:host=$servername", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected successfully";
	$row = "aaaaa";
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}
?>

<html>
	<body>
		<h1>1111111111111</h1>
		<?php 
		echo $row;
		?>
	</body>

</html>