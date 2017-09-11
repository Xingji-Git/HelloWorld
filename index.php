<?php
session_start();
$msg = "";
if(isset($_POST['username'])&&isset($_POST['passwd']))
{
	$username=$_POST['username'];
	$password=$_POST['passwd'];
	include_once 'login.php';
	$login_result = login($username,$password);
	$result_name = $login_result->fetch()['user'];
	if($result_name == $username && $username !== ""){
		$_SESSION['user']=$username;
		header('Location: index.php');
	}
	else{
        	$msg = "Invalid username or password!";
	}
}

if(isset($_SESSION['user'])){
	echo "Hello ".$_SESSION['user'];
	echo "
	<html>
	<body><form action=\"logout.php\" method=\"POST\" ><input type=\"submit\" value=\"log out\" /></form></body>
	</html>
	";
}
else{
	echo $msg."
	<br>
	<html>
	<body>
	<form action=\"index.php\" method=\"POST\">
	<input name=\"username\" />
	<input type=\"password\"  name=\"passwd\" />
	<input type=\"submit\" value=\"log in\" />
	</form>
	</body>
	</html>
	";
}

$conn=null;
?>
